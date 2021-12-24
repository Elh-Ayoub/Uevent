<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;

class PublishEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:events';

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
        $events = Event::where(['published' => 'no'])->get();
        foreach($events as $event){
            info(date('Y-m-d H:i') . " --- " . gmdate('Y-m-d H:i', strtotime($event->publish_at)));
            if(date('Y-m-d H:i') == gmdate('Y-m-d H:i', strtotime($event->publish_at))){
                $event->update(['published' => 'yes']);
            }
        }
        return Command::SUCCESS;
    }
}
