<?php

namespace App\Jobs;
use App\Models\notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SlaWarningJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $user_id;
    public $ticket_id;
    public $message;
    public function __construct( $user_id,$ticket_id,$message)
    {
        $this->user_id=$user_id;
        $this->ticket_id=$ticket_id;
        $this->message=$message;


        //

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // notification::create([
        //     'user_id'=>$this->user_id,
        //     'title'=>"SLA warning",
        //     'description'=>$this->message,
        //     'tickets_id'=> $this->ticket_id,
        //     'is_read'=>0


        // ]);
        notification::create([
    'user_id'=>21,
    'title'=>'TEST',
    'description'=>'scheduler working',
    'tickets_id'=>1,
    'is_read'=>0
]);
    }
}
