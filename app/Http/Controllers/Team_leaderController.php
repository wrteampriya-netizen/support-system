<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\notification;
use App\Models\ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Team_leaderController extends Controller
{


    public function myTickets()
    {
        $user_id = Auth::id();

        $users = User::role('Support Agent')
            ->select('id', 'name')
            ->get();




        $tickets = DB::table('tickets')
            ->where('assign_to', $user_id)
            ->whereNull('agent_id')
            ->where('status', 'open')
            ->orderBy('created_at', 'desc')
            ->get();


        $acceptedTickets = DB::table('tickets')
            ->where('assign_to', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();


        $notification = notification::where('user_id', auth()->id())->latest()->get();

        return view('team_leader.create', compact(
            'tickets',
            'acceptedTickets',
            'users',
            'notification'
        ));
    }



    public function accept($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([


                'status' => 'open',

                'updated_at' => now()
            ]);

        return redirect()->back()
            ->with('success', 'Ticket accepted');
    }



    public function reject($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([


                'status' => 'closed',


                'assign_to' => null,

                'updated_at' => now()
            ]);

        return redirect()->back()
            ->with('success', 'Ticket rejected');
    }



    public function assign(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required',
            'agent_id' => 'required'
        ]);

        $ticketIds = explode(',', $request->ticket_ids);

        $agent_id = $request->agent_id;

        foreach ($ticketIds as $ticket) {

            DB::table('tickets')
                ->where('id', $ticket)
                ->update([


                    'agent_id' => $agent_id,


                    'status' => 'open',

                    'updated_at' => now()
                ]);
            $ticket = ticket::find($ticket);

            notification::create([

                'user_id' => $agent_id,
                'title' => $ticket->subject,
                'description' => $ticket->description,
                'tickets_id' => $ticket->id,
                'is_read' => 0

            ]);
        }




        return back()
            ->with('success', 'Ticket assigned successfully');
    }



    public function myTeam()
    {
        $owner_id = auth()->id();

        $team = Team::with(['members.tickets'])
            ->where('owner_id', $owner_id)
            ->first();

        return view('team_leader.Team-detail', compact('team'));
    }



    public function allTeam()
    {
        $team = Team::with('members.tickets', 'leader')
            ->get();

        foreach ($team as $teams) {

            $teams->total_tickets = $teams->members
                ->sum(function ($member) {

                    return $member->tickets->count();
                });
        }

        return view('team_leader.allteam', compact('team'));
    }



    public function updatestaus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,pending,resolved,closed'
        ]);

        $ticket = DB::table('tickets')
            ->where('id', $id)
            ->first();




        if (
            $ticket->status == 'open' &&
            $request->status == 'in_progress'
        ) {

            DB::table('tickets')
                ->where('id', $id)
                ->update([
                    'status' => 'in_progress',
                    'updated_at' => now()
                ]);
        } elseif (
            $ticket->status == 'in_progress' &&
            $request->status == 'pending'
        ) {

            DB::table('tickets')
                ->where('id', $id)
                ->update([
                    'status' => 'pending',
                    'updated_at' => now()
                ]);
        } elseif (
            $ticket->status == 'pending' &&
            $request->status == 'in_progress'
        ) {

            DB::table('tickets')
                ->where('id', $id)
                ->update([
                    'status' => 'in_progress',
                    'updated_at' => now()
                ]);
        } elseif (
            $ticket->status == 'in_progress' &&
            $request->status == 'resolved'
        ) {

            DB::table('tickets')
                ->where('id', $id)
                ->update([
                    'status' => 'resolved',
                    'updated_at' => now()
                ]);
        } elseif (
            $ticket->status == 'resolved' &&
            $request->status == 'closed'
        ) {

            DB::table('tickets')
                ->where('id', $id)
                ->update([
                    'status' => 'closed',
                    'updated_at' => now()
                ]);
        }

        return redirect()->back()
            ->with('success', 'Ticket status updated');
    }


    public function openNotification($id)
    {
        $notification = notification::find($id);
        if ($notification) {
            $notification->update([
                'is_read' => 1

            ]);
            return redirect()->route(
                'leader.tickets',
                ['ticket_id' => $notification->tickets_id]
            );
        }
        return back();
    }
}
