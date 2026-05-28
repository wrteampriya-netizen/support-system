<?php

namespace App\Http\Controllers;

use  App\Jobs\ActivityLogJob;
use App\Models\Team;
use App\Models\User;
use App\Models\notification;
use App\Models\ticket;
use App\Models\ActivityLog;
use App\Jobs\sendnotificationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

        $notification = notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('team_leader.create', compact(
            'tickets',
            'acceptedTickets',
            'users',
            'notification'
        ));
    }


    // ACCEPT TICKET

    public function accept($id)
    {
        $ticket = DB::table('tickets')
            ->where('id', $id)
            ->first();

        DB::table('tickets')
            ->where('id', $id)
            ->update([
                'status' => 'open',
                'updated_at' => now()
            ]);

        ActivityLogJob::dispatch(
            auth()->id(),
            'Leader accepted ticket',
            $ticket->status,
            'open',
            $id
        );

        return redirect()->back()
            ->with('success', 'Ticket accepted');
    }


    // REJECT TICKET

    public function reject($id)
    {
        $ticket = DB::table('tickets')
            ->where('id', $id)
            ->first();

        DB::table('tickets')
            ->where('id', $id)
            ->update([
                'status' => 'closed',
                'assign_to' => null,
                'updated_at' => now()
            ]);

        ActivityLogJob::dispatch(
            auth()->id(),
            'Leader rejected ticket',
            $ticket->status,
            'closed',
            $id
        );

        return redirect()->back()
            ->with('success', 'Ticket rejected');
    }


    // ASSIGN TO AGENT

    public function assign(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required',
            'agent_id' => 'required'
        ]);

        $ticketIds = explode(',', $request->ticket_ids);
        $agent_id = $request->agent_id;

        foreach ($ticketIds as $ticketId) {

            DB::table('tickets')
                ->where('id', $ticketId)
                ->first();

            DB::table('tickets')
                ->where('id', $ticketId)
                ->update([
                    'agent_id' => $agent_id,
                    'status' => 'open',
                    'updated_at' => now()
                ]);
                   Cache::forget('admin_dashboard');
Cache::forget('ticket_report');
                
            $agent = User::find($agent_id);

            ActivityLogJob::dispatch(
                auth()->id(),
                'Assigned to Agent',
                'Unassigned',
                $agent->name,
                $ticketId
            );

            $ticketModel = ticket::find($ticketId);

            sendnotificationJob::dispatch(
                $agent_id,
                $ticketModel->subject,
                $ticketModel->description,
                $ticketModel->id

            );
        }

        return back()
            ->with('success', 'Ticket assigned successfully');
    }


    // STATUS UPDATE FLOW

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,pending,resolved,closed'
        ]);

        $ticket = DB::table('tickets')
            ->where('id', $id)
            ->first();

        $old = $ticket->status;
        $new = $request->status;

        DB::table('tickets')
            ->where('id', $id)
            ->update([
                'status' => $new,
                'updated_at' => now()
            ]);
            Cache::forget('admin_dashboard');
Cache::forget('ticket_report');

        ActivityLogJob::dispatch(
            auth()->id(),
            'Status Changed by Leader',
            $old,
            $new,
            $id
        );

        return redirect()->back()
            ->with('success', 'Ticket status updated');
    }


    // TEAM

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
        $team = Team::with('members.tickets', 'leader')->get();

        foreach ($team as $teams) {
            $teams->total_tickets = $teams->members->sum(function ($member) {
                return $member->tickets->count();
            });
        }

        return view('team_leader.allteam', compact('team'));
    }


    // NOTIFICATION OPEN

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
