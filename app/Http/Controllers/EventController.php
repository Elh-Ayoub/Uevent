<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Event;
use App\Models\PromoCode;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use File;
use Intervention\Image\ImageManagerStatic as Image;

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
            'poster' => 'required|image|mimes:jpg,png|max:20000|dimensions:min_width=350,min_height=280',
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
            'poster' => $this->uploadImage($request),
            'receive_notif' => $request->receive_notif,
            'published' => $published,
            'can_see_visitors' => $request->can_see_visitors,
            'publish_at' => ($request->publish_at) ? date('Y-m-d H:i:s', strtotime($request->publish_at)) : (null),
            'begins_at' => date('Y-m-d H:i:s', strtotime($request->begins_at)),
            'location' => $request->location,
            'category' => $request->category,
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
        if(count($request->code) > 0){
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
        (count(Event::all()) >= 4) ? ($rand = 4) : ($rand = count(Event::all()));
        return view('Events.details', [
            'event' => $event, 
            'subscribe' => Subscribe::where(['author' => Auth::id(), 'event_id' => $id])->first(),
            'event_subs' => Subscribe::where('event_id', $id)->get(),
            'comments' => Comment::where('event_id', $id)->get(),
            'similar_events' => Event::where('category', $event->category)->get()->random($rand),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
