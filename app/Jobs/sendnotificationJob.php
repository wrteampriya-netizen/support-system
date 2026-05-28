<?php

namespace App\Jobs;

use App\Models\notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class sendnotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $user_id;
    public $title;
    public $description;
    public $ticket_id;

    public function __construct($user_id,$title,$description,$ticket_id)
    {
        //
        $this->user_id=$user_id;
        $this->title=$title;
        $this->description=$description;
        $this->ticket_id=$ticket_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
         

        notification::create([
            'user_id'=>$this->user_id,
            'title'=>$this->title,
            'description'=>$this->description,
            'tickets_id'=>$this->ticket_id,
            'is_read'=>0
        ]);
    }
}
