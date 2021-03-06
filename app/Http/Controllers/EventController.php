<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Event;
use App\Models\NotifSubscribe;
use App\Models\PromoCode;
use App\Models\Subscribe;
use App\Models\User;
use App\Notifications\EventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\Notification;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['events' => Event::where('published', 'yes')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Events.create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:100'],
            'ticket_price' => ['required'],
            'poster' => 'image|mimes:jpg,png|max:20000|dimensions:min_width=350,min_height=280',
            'location' =>['required'],
            'begins_at' => ['required'],
            'category' => ['required'],
        ]);
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        if($request->publish_at_selector === 'now'){
            $published = 'yes';
        }else{
            $published = 'no';
        }
        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'author' => Auth::id(),
            'tickets_limited' => $request->tickets_limited,
            'tickets_number' => $request->tickets_number,
            'ticket_price' => $request->ticket_price,
            'poster' => ($request->file('poster')) ? $this->uploadImage($request) : (asset('images/default-poster.png')),
            'receive_notif' => $request->receive_notif,
            'published' => $published,
            'can_see_visitors' => $request->can_see_visitors,
            'publish_at' => ($request->publish_at) ? date('Y-m-d H:i:s', strtotime($request->publish_at)) : (null),
            'begins_at' => date('Y-m-d H:i:s', strtotime($request->begins_at)),
            'location' => $request->location,
            'category' => $request->category,
            'behalf_of_company' => ($request->behalf_of_company) ? ($request->behalf_of_company) : ('no'),
        ]);
        if($event){
            if($request->code){
              $this->storePromoCode($request, $event->id); 
            }
            return redirect('events/create')->with('success', 'Event craeted successfully!');
        }else{
            return redirect('events/create')->with('fail', 'Something went wrong! Try again.');
        }
    }

    function uploadImage($request){
        $image = $request->file('poster');
        if($image){
            $filename = uniqid().".".File::extension($image->getClientOriginalName());
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(1080 , 1350);
            $image_resize->save(public_path('/event-posters/' .$filename));
            return url('/event-posters/' . $filename);
        }
        return null;
    }

    function storePromoCode($request, $id){
        if($request->code && count($request->code) > 0){
            for($i=0; $i < count($request->code); $i++){
                PromoCode::create([
                    'author' => Auth::id(),
                    'code' => $request->code[$i],
                    'percentage' => $request->percentage[$i],
                    'event_id' => $id,
                ]);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        if(!$event){
            return redirect('/home')->with('fail', 'Event not found!');
        }
        (count(Event::where('category', $event->category)->get()) >= 4) ? ($rand = 4) : ($rand = count(Event::where('category', $event->category)->get()));
        return view('Events.details', [
            'event' => $event, 
            'subscribe' => Subscribe::where(['author' => Auth::id(), 'event_id' => $id])->first(),
            'event_subs' => Subscribe::where('event_id', $id)->get(),
            'comments' => Comment::where('event_id', $id)->get(),
            'similar_events' => Event::where('category', $event->category)->get()->random($rand),
            'notif_sub' => NotifSubscribe::where(['event_id' => $id, 'author' => Auth::id()])->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        if(!$event){
            return back()->with('fail', 'Event not found!');
        }
        return view('Events.edit', [
            'event' => $event,
            'promo_codes' => PromoCode::where('event_id', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:100'],
            'ticket_price' => ['required'],
            'poster' => 'image|mimes:jpg,png|max:20000|dimensions:min_width=350,min_height=280',
            'location' =>['required'],
            'begins_at' => ['required'],
            'category' => ['required'],
        ]);
        $event = Event::find($id);
        $poster = $event->poster;
        if($request->file('poster')){

            $poster = $this->uploadImage($request);
        }
        if(!$event){
            return back()->with('fail', 'Event not found!');
        }
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        $event->update(array_merge($request->all(), [
            'poster' => $poster,
            'begins_at' => date('Y-m-d H:i:s', strtotime($request->begins_at)),
            'publish_at' => ($request->publish_at) ? date('Y-m-d H:i:s', strtotime($request->publish_at)) : (null),
        ]));
        PromoCode::where('event_id', $id)->delete();
        $this->storePromoCode($request, $id); 
        return back()->with('success', 'Event updated successfully!');
    }

    public function NotifyVisitors(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:500'],
        ]);
        $event = Event::find($id);
        if(!$event){
            return back()->with('fail', 'Event not found!');
        }
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        $data = [
            'body' => $request->content,
            'action' => 'Event details',
            'url' => route('event.details', $id),
        ];
        $ids = array();
        foreach(NotifSubscribe::where('event_id', $id)->get() as $subs){
            array_push($ids, $subs->author);
        }
        $subscribers = User::find($ids);
        Notification::send($subscribers, new EventNotification($data));
        foreach($ids as $user){
            DB::table('notifications')->insert([
                'author' => Auth::id(),
                'event_id' => $id,
                'data' => $data['body'],
                'send_to' => $user,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        
        return back()->with('success','Notification sent successfull!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
        ]);
        $event = Event::find($id);
        if(!$event){
            return back()->with('fail', 'Event not found!');
        }
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        if((Auth::id() == $event->author) && Hash::check($request->password, Auth::user()->password)){
            $data = [
                'body' => 'An event you are subscribed in ('. $event->title .') has been removed!',
                'action' => 'Check more events',
                'url' => route('dashboard'),
            ];
            $ids = array();
            foreach(NotifSubscribe::where('event_id', $id)->get() as $sub){
                array_push($ids, $sub->author);
            }
            $subscribers = User::find($ids);
            Notification::send($subscribers, new EventNotification($data));
            foreach($ids as $user){
                DB::table('notifications')->insert([
                    'author' => Auth::id(),
                    'event_id' => $id,
                    'data' => $data['body'],
                    'send_to' => $user,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            $event->delete();
            return back()->with('success', 'Event deleted successfully!');
        }else{
            return back()->with('fail', 'Password incorrect!');
        }
    }
}
