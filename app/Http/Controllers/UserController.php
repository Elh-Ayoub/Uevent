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
            'week_subs' => $this->weekSubsInfo(),
            'year_subs' => $this->yearSubsInfo(),
        ]);
    }
    public function getMyEvents(){
        $myevents = array();
        foreach(Event::where('author', Auth::id())->get() as $event){
            array_push($myevents, $event->id); 
        }
        return $myevents;
    }
    public function todaySubsInfo(){
        $today_subs = array();
        $timestamps = array();
        $myevents = $this->getMyEvents();
        $subs = Subscribe::whereDate('created_at', Carbon::today())->get();
        foreach($subs as $sub){
            if(in_array($sub->event_id, $myevents)){
                array_push($today_subs, strtotime(date('Y-m-d H:00', strtotime($sub->created_at))));
            }
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

    public function weekSubsInfo(){
        $week_info = array();
        $myevents = $this->getMyEvents();
        for ($i=0; $i < 7; $i++) {
            $week_day = date('Y-m-d H:i:s', strtotime(Carbon::now()->startOfWeek(). ' + ' . $i .' days'));
            $subs = array();
            foreach(Subscribe::whereDate('created_at', $week_day)->get() as $sub){
                if(in_array($sub->event_id, $myevents)){
                    array_push($subs, $sub);
                }
            }
            array_push($week_info, [$i+1, count($subs)]);
        }
        return $week_info;
    }

    public function yearSubsInfo(){
        $year_info = array();
        $myevents = $this->getMyEvents();
        for ($i=1; $i <= 12; $i++) {
            $subs = array();
            foreach(Subscribe::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->get() as $sub){
                if(in_array($sub->event_id, $myevents)){
                    array_push($subs, $sub);
                }
            }
            array_push($year_info, [$i, count($subs)]);
        }
        return $year_info;
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
