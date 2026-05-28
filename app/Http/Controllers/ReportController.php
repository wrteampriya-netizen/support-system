<?php

namespace App\Http\Controllers;

use App\Models\ticket;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function ticketReport()
    {
        $total = ticket::count();
        $openTicket = ticket::where('status', 'open')->count();
        $closeTicekts = ticket::where('status', 'closed')->count();
        $PendingTicekts = ticket::where('status', 'Pending')->count();
        $ResolvedTicekts = ticket::where('status', 'Resolved')->count();
        $InProgressTicekts = ticket::where('status', 'in_progress')->count();

        return view('report.tickets', compact('total', 'openTicket', 'closeTicekts', 'PendingTicekts', 'ResolvedTicekts', 'InProgressTicekts'));
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
            ->where('status', '!=', 'closed')
           
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
