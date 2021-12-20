<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PromoCode;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{

    public function EventSubscriptionView($id){
        $event = Event::find($id);
        if(!$event){
            return back()->with('fail', 'event not found!');
        }
        if(Subscribe::where(['author' => Auth::id(), 'event_id' => $id])->first()){
            return redirect()->route('event.details', $id)->with('success', 'Subscribed successfully!');
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

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'show_name' => 'required',
        ]);
        if($validator->fails()){
            return back()->with('fail-arr', json_decode($validator->errors()->toJson()));
        }
        $sub = Subscribe::find($id);
        if(!$sub){
            ['fail' => 'Subscribe not found!'];
        }
        $sub->update(['show_name' => $request->show_name]);
        return ['success' => 'updated successfully!'];
    }

    public function store($id){
        $subscribe = Subscribe::create([
            'author' => Auth::id(),
            'event_id' => $id,
        ]);
        $this->emailNotif($subscribe);
        return $subscribe;
    }

    public function freeSub($id){
        if($this->store($id)){
           return ['success' => 'Subscribed successfully!'];
        }else{
            return ['fail' => 'Somrthing went wrong! Try again.'];
        }
    }

    public function emailNotif($sub){
        if($sub->author != Auth::id() || !Event::find($sub->event_id)){
            return null;
        }
        $data = array(
            'event' => Event::find($sub->event_id),
            'user' => Auth::user(),
            'ticket' => $sub,
        );
        Mail::send('Emails.sub-notification',$data, function($message ) use($data) {
            $message->to($data['user']->email, 'Subscription notification')->subject('Notification');
            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
        });
    }
}
