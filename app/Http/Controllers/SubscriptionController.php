<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PromoCode;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe;

class SubscriptionController extends Controller
{

    public function EventSubscriptionView($id){
        $event = Event::find($id);
        if(!$event){
            return back()->with('fail', 'event not found!');
        }

        return view('Events.subscribe', ['event' => $event]);
    }

    public function fetshPromoCode(Request $request, $id){
        $event = Event::find($id);
        if(!$event){
            return ['fail' => 'Event not found!'];
        }
        $promoCodes = PromoCode::where(['code' => $request->code, 'event_id' => $id])->first();
        if($promoCodes){
            return ['success' => $promoCodes];
        }else{
            return ['fail' => 'Promo not not exist!'];
        }
    }

    public function paySubscription(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'card_number' => 'required|string|max:16',
            'cvc' => 'required|string|max:3',
            'month' => 'required|string|max:2',
            'year' => 'required|string|max:4',
            'name_on_card' => 'required|string|max:30',
            'stripeToken' => 'required',
        ]);
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        $event = Event::find($id);
        if(!$event){
            return redirect('/home')->with('fail', 'Event not found!');
        }
        $price = $event->ticket_price;
        if($event->ticket_price > 0){
            if($request->promocode){
                $promoCode = PromoCode::where('code', $request->promocode)->first();
                if(!$promoCode){
                    return back()->with('fail', 'Promo code not availabe');
                }else{
                    $price -= (($price * $promoCode->percentage) / 100);
                }
            }
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $payment = Stripe\Charge::create ([
                "amount" => $price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Subscription to event :  id: " . $event->id . " Title: " . $event->title, 
            ]);
            if($payment){
                $this->store($id);
                return redirect()->route('event.details', $event->id)->with('success', 'Subscribed successfully!');
            }else{
                return back()->with('fail', 'Somrthing went wrong!');
            }
        }else{
            $this->store($id);
            return redirect()->route('event.details', $event->id)->with('success', 'Subscribed successfully!');
        }
    }

    public function store($id){
        $subscribe = Subscribe::create([
            'author' => Auth::id(),
            'event_id' => $id,
        ]);
        return $subscribe;
    }

    public function freeSub($id){
        if($this->store($id)){
           return ['success' => 'Subscribed successfully!'];
        }else{
            return ['fail' => 'Somrthing went wrong! Try again.'];
        }
    }
}
