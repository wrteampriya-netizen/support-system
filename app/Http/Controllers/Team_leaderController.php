<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\notification;
use App\Models\ticket;
use App\Models\ActivityLog;
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

    // =========================
    // ACCEPT TICKET
    // =========================
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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Leader accepted ticket',
            'old_value' => $ticket->status,
            'new_value' => 'open',
            'ticket_id' => $id
        ]);

        return redirect()->back()
            ->with('success', 'Ticket accepted');
    }

    // =========================
    // REJECT TICKET
    // =========================
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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Leader rejected ticket',
            'old_value' => $ticket->status,
            'new_value' => 'closed',
            'ticket_id' => $id
        ]);

        return redirect()->back()
            ->with('success', 'Ticket rejected');
    }

    // =========================
    // ASSIGN TO AGENT
    // =========================
    public function assign(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required',
            'agent_id' => 'required'
        ]);

        $ticketIds = explode(',', $request->ticket_ids);
        $agent_id = $request->agent_id;

        foreach ($ticketIds as $ticketId) {

            $ticket = DB::table('tickets')
                ->where('id', $ticketId)
                ->first();

            DB::table('tickets')
                ->where('id', $ticketId)
                ->update([
                    'agent_id' => $agent_id,
                    'status' => 'open',
                    'updated_at' => now()
                ]);
                $agent = User::find($agent_id);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'Assigned to Agent',
                'old_value' => 'Unassigned',
                'new_value' => $agent->name,
                'ticket_id' => $ticketId
            ]);

            $ticketModel = ticket::find($ticketId);

            notification::create([
                'user_id' => $agent_id,
                'title' => $ticketModel->subject,
                'description' => $ticketModel->description,
                'tickets_id' => $ticketModel->id,
                'is_read' => 0
            ]);
        }

        return back()
            ->with('success', 'Ticket assigned successfully');
    }

    // =========================
    // STATUS UPDATE FLOW
    // =========================
    public function updatestaus(Request $request, $id)
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

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Status Changed by Leader',
            'old_value' => $old,
            'new_value' => $new,
            'ticket_id' => $id
        ]);

        return redirect()->back()
            ->with('success', 'Ticket status updated');
    }

    // =========================
    // TEAM
    // =========================
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

    // =========================
    // NOTIFICATION OPEN
    // =========================
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
