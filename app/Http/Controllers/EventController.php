<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use File;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Events.create');
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
            'tickets_number' => ['required'],
            'ticket_price' => ['required'],
            'poster' => 'required|image|mimes:jpg,png|max:20000|dimensions:min_width=350,min_height=280',
            'location' =>['required'],
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
            'tickets_number' => $request->tickets_number,
            'ticket_price' => $request->ticket_price,
            'poster' => $this->uploadImage($request),
            'receive_notif' => $request->receive_notif,
            'published' => $published,
            'can_see_visitors' => $request->can_see_visitors,
            'publish_at' => ($request->publish_at) ? date('D M d Y H:i:s', strtotime($request->publish_at)) : (null),
            'location' => $request->location,
        ]);
        if($event){
            return redirect('events/create')->with('success', 'Event craeted successfully!');
        }else{
            return redirect('events/create')->with('fail', 'Something went wrong! Try again.');
        }
    }

    function uploadImage($request){
        $image = $request->file('poster');
        if($image){
            $filename = uniqid().".".File::extension($image->getClientOriginalName());
            $image = $request->file('poster')->store('public');
            $image1 = $request->file('poster')->move(public_path('/event-posters'), $filename);
            return url('/event-posters/' . $filename);
        }
        return null;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
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
