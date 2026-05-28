<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Mail;
use App\Mail\ticketCreatedMail;
use App\Models\ticket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TicktCreatedjob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $ticket;
    public $email;
    public function __construct($ticket,$email)
    {
        //
        $this->ticket=$ticket;
        $this->email=$email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        

        Mail::to($this->email)
            ->send(new ticketCreatedMail($this->ticket));
    }
}
