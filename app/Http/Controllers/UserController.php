<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myevents = Event::where('author', Auth::id())->get();
        return view('User.account', [
            'my_events' => $myevents,
            'today_subs' => $this->todaySubsInfo(),
        ]);
    }

    public function todaySubsInfo(){
        $today_subs = array();
        $timestamps = array();
        $subs = Subscribe::whereDate('created_at', Carbon::today())->get();
        foreach($subs as $sub){
            array_push($today_subs, strtotime(date('Y-m-d H:00', strtotime($sub->created_at))));
        }
        for($i = 0; $i < 24 ; $i++){
            array_push($timestamps, strtotime(date('Y-m-d '. $i .':00'))); 
        }
        $today_subs = array_count_values($today_subs);
        $keys = array();
        $vals = array();
        foreach($timestamps as $timestamp){
            if(in_array($timestamp, array_keys($today_subs))){
                array_push($keys, $timestamp);
                array_push($vals, $today_subs[$timestamp]);
            }else{
                array_push($keys, $timestamp);
                array_push($vals, 0);
            }
        }
        
        return [$keys, $vals];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
