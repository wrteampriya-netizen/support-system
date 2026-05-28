<?php

namespace App\Jobs;
use App\Models\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ActivityLogJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $user_id;
    public $action;
    public $old_value;
    public $new_value;
    public $ticket_id;
    public function __construct( $user_id,$action,$old_value,$new_value,$ticket_id)
    {
        //
        $this->user_id=$user_id;
        $this->action=$action;
        $this->old_value=$old_value;
        $this->new_value=$new_value;
        $this->ticket_id=$ticket_id;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        
         ActivityLog::create([
            'user_id'   =>   $this->user_id,
            'action'    =>   $this->action,
            'old_value' =>   $this->old_value,
            'new_value' =>  $this->new_value,
            'ticket_id' =>   $this->ticket_id
        ]);
    }
}
