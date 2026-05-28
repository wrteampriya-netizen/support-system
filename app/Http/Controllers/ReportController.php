<?php

namespace App\Http\Controllers;

use App\Models\ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    //
    public function ticketReport()
    {
        $data=Cache::remember('ticket_report',300,function(){
            return [
                'total' => ticket::count(),
        'openTicket' => ticket::where('status', 'open')->count(),
        'closeTicekts' => ticket::where('status', 'closed')->count(),
        'PendingTicekts' => ticket::where('status', 'Pending')->count(),
        'ResolvedTicekts' => ticket::where('status', 'Resolved')->count(),
        'InProgressTicekts' => ticket::where('status', 'in_progress')->count(),
            ];

        });
        // $total = ticket::count();
        // $openTicket = ticket::where('status', 'open')->count();
        // $closeTicekts = ticket::where('status', 'closed')->count();
        // $PendingTicekts = ticket::where('status', 'Pending')->count();
        // $ResolvedTicekts = ticket::where('status', 'Resolved')->count();
        // $InProgressTicekts = ticket::where('status', 'in_progress')->count();

        return view('report.tickets', $data);
    }

    public function agentReport()
    {
        $agents = User::role('Support Agent')
            ->withCount('tickets')
            ->get();

        return view('report.agent', compact('agents'));
    }


    public function SlaReport()
    {
       $slaTickets = ticket::where('sla_deadline', '<', now())
    ->whereNotIn('status', ['closed', 'Resolved'])
    ->latest()
    ->get();

            

            return view('report.sal', compact('slaTickets'));
    }


    // public function cutomerReport(){
    //     $user=User::role('customer')->withCount('UserTicket')->get();
    //     return view('report.customer',compact('user'));
    // }
    public function cutomerReport(){

    $user = User::role('customer')
        ->withCount('UserTicket')
        ->get();
        

    return view('report.customer',compact('user'));
}
}
