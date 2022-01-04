<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            'my_tickets' => Subscribe::where('author', Auth::id())->get(),
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
    
    public function update(Request $request, $id){
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username' => 'string|between:5,30',
            'full_name' => 'string|between:5,30',
            'email' => 'string|email|max:100',
        ]);
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        $profile_photo = $user->profile_photo;
        if($user->username != $request->username && User::where('username', $request->username)->first()){
            return back()->with('fail', 'username already exist!');
        }
        if($user->email != $request->email && User::where('email', $request->email)->first()){
            return back()->with('fail', 'Email already exist!');
        }
        if($request->username && $user->username !== $request->username ){
            if(str_contains(parse_url($user->profile_photo, PHP_URL_PATH), '.png')){
                $filename = str_replace(' ', '-', $request->input('username')) . '.png';
                Storage::move(parse_url($user->profile_photo, PHP_URL_PATH),
                '/profile-pictures/' . $filename);
                $profile_photo = url('profile-pictures/'. $filename);
            }else{
                $profile_photo = 'https://ui-avatars.com//api//?name='.substr($request->username, 0, 2).'&color=7F9CF5&background=EBF4FF';
            }
        }
        $user->update(array_merge($request->all(), ['profile_photo' => $profile_photo]));
        return back()->with('success', 'Account Updated successfully!');
    }

    public function updateAvatar(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,png|max:20000',
        ]);
        if($validator->fails()){
            return back()->with($validator->errors()->toArray());
        }
        if(Auth::user()){
          $user = Auth::user();  
        }
        if($request->user){
            $user = $this->show($request->user);
        }
        $image = $request->file('image');
        if($image){
            $fileName = str_replace(' ', '-', $user->username) . '.png';
            $image = $request->file('image')->store('public');
            $image1 = $request->file('image')->move(public_path('/profile-pictures'), $fileName);
            $user->update(['profile_photo' => url('/profile-pictures/' . $fileName)]);
            return  back()->with('success', 'Profile picture updated successfully!');
        }
        return response()->json('error', 404);
    }
    
    public function UpdatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:8',
            'password' => 'required|string|confirmed|min:8',
        ]);
        $user = Auth::user();
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        if(Hash::check($request->current_password, $user->password)){
            $user->update(['password' => bcrypt($request->password)]);
            return back()->with('success', 'Password Updtaed!');
        }else{
            return back()->with('fail', 'Incorrect password!');
        }
    }

    public function setDefaultAvatar(Request $request){
        $user = Auth::user();
        $name = substr($user->username, 0, 2);
        File::delete(public_path(parse_url($user->profile_photo, PHP_URL_PATH)));
        $profile_photo = 'https://ui-avatars.com//api//?name='.$name.'&color=7F9CF5&background=EBF4FF';
        $user->update(['profile_photo' => $profile_photo]);
        return back()->with('success', 'Profile picture deleted!');
    }

    public function destroyAuthUser(){
        Event::where('author', Auth::id())->delete();
        Auth::user()->delete();
        return redirect('auth/login')->with('success', 'Account deleted successfully!');
    }

    public function contactUsView(){
        return view('contact-us');
    }

    public function contactUs(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        $data = array('name'=> $request->name,
          'email'=> $request->email,
          'subject' => $request->subject,
          'content' => $request->message,
        ); 
        Mail::send('Emails.contactMail',$data, function($message ) use($data) {
           $message->to(env('MAIL_USERNAME'), 'Contact')->subject($data['subject']);
           $message->from($data['email'], $data['name']);
        });
        return back()->with('success', 'Message sent successfully!');
    }
}
