<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function EventSubscriptionView($id){
        $event = Event::find($id);
        if(!$event){
            return back()->with('fail', 'event not found!');
        }

        return view('Events.subscribe', ['event' => $event]);
    }

    // public function EventSubscription(Request $request, $id){

    // }

    public function fetshPromoCode(Request $request, $id){
        $event = Event::find($id);
        if(!$event){
            return ['fail' => 'Event not found!'];
        }
        $promoCodes = PromoCode::where('code', $request->code)->first();
        if($promoCodes){
            return ['success' => $promoCodes];
        }else{
            return ['fail' => 'Promo not not exist!'];
        }
    }
}
