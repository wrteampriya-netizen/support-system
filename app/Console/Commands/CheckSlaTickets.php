<?php

namespace App\Console\Commands;

use App\Jobs\SlaWarningJob;
use App\Models\ticket;
use Illuminate\Console\Command;

class CheckSlaTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    
    protected $signature = 'app:check-sla-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $tickets=ticket::where('status','!=','closed')->where('status','!=','Resolved')->get();

        foreach($tickets as $ticket){
    
        $remainingmin=now()->diffInMinutes($ticket->sla_deadline,false);

        if($remainingmin < 60 &&  $remainingmin > 0 ){
            SlaWarningJob::dispatch(
                $ticket->agent->id,
                $ticket->id,
                "Ticket #{{tickets->id}} SLA breach soon."

            );
        }
        }

    }
}
