<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Subscribe;
use App\Models\User;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class TodayEventReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:TodayEventReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $todayEvents = Event::whereDate('begins_at', Carbon::today())->get();
        foreach($todayEvents as $event){
            //send email to each event
            $subs = Subscribe::where('event_id', $event->id)->get();
            foreach($subs as $sub){
                $visitor = User::find($sub->author);
                $data = [
                    'event' => $event,
                    'msg' => 'Hello! Today begins ' . $event->title . ' get your self ready.',
                    'user' => $visitor,
                ];
                Mail::send('Emails.TodayEventNotification', $data, function($message) use($data) {
                    $message->to($data['user']->email, 'Event notification')->subject('Event notification');
                    $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                });
                info($visitor->username . " --- " . $event->title);
            }
        }
        return Command::SUCCESS;
    }
}
