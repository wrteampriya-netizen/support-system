<?php



namespace App\Http\Controllers;
use App\Jobs\TicktAssignjob;
use Illuminate\Http\Request;
use App\Models\team;
use App\Models\User;
use App\Models\ticket;
use App\Models\notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ticketAssignMail;
use App\Models\ActivityLog;

class TeamCreateCntroller extends Controller
{
    public function userget()
    {

        $users = User::role(['Support Agent', 'Team Leader'])->get();

        return view('admin.team', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_name'   => 'required',
            'team_leader' => 'required',
            'agents'      => 'required|array'
        ]);




        $team = team::create([
            'name'        => $request->team_name,
            'description' => $request->description,
            'owner_id'    => $request->team_leader,
        ]);


        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'team is created',
            'old_value' => null,
            'new_value' => $team->name,
            'ticket_id' => null
        ]);

        $team->members()->attach($request->agents);

        return redirect()->route('homepage')
            ->with('success', 'team created');
    }

    public function showindex()
    {
        return view('admin.index');
    }

    public function fetch()
    {
        $data = team::with(['leader', 'members'])->get();

        return response()->json($data);
    }

    public function edit($id)
    {
        $data = team::with('members')->findOrFail($id);

        $users = User::role(['Support Agent', 'Team Leader'])->get();

        return view('admin.edit', compact('data', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'team_name'   => 'required',
            'team_leader' => 'required',
            'agents'      => 'required|array'
        ]);

        $data = team::findOrFail($id);



        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'team is updated',
            'old_value' => $data->name,
            'new_value' => $request->team_name,
            'ticket_id' => null
        ]);

        $data->update([
            'name'        => $request->team_name,
            'description' => $request->description,
            'owner_id'    => $request->team_leader
        ]);


        $data->members()->sync($request->agents);

        return redirect()->route('team.showindex')
            ->with('success', 'updated team');
    }

    public function delete($id)
    {
        $team = team::findOrFail($id);


        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'team is deleted',
            'old_value' => $team->name,
            'new_value' => null,
            'ticket_id' => null
        ]);

        $team->members()->detach();

        $team->delete();



        return redirect()->route('team.showindex')
            ->with('success', 'deleted team');
    }


    public function showForm()
    {
        $users = User::role(['Team Leader', 'Support Agent'])
            ->select('id', 'name', 'email')
            ->get();


        $newTickets = DB::table('tickets')
            ->whereNull('assign_to')
            ->where('status', 'open')
            ->get();

        return view('admin.assign', compact('users', 'newTickets'));
    }



    public function acceptTicket($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([


                'assign_to' => auth()->id(),

                'updated_at' => now()
            ]);

        return redirect()->back()
            ->with('success', 'Ticket moved to leader!');
    }



    public function assign(Request $request)
    {
        $request->validate([
            'leader_id' => 'required',
            'ticket_ids' => 'required'
        ]);

        $ticketIds = explode(',', $request->ticket_ids);

        $leader_id = $request->leader_id;

        $leader = DB::table('users')
            ->where('id', $leader_id)
            ->first();

        foreach ($ticketIds as $ticket) {

            DB::table('tickets')
                ->where('id', $ticket)
                ->update([


                    'assign_to'  => $leader_id,


                    'status'     => 'open',

                    'updated_at' => now(),
                ]);

            $ticketdetail = DB::table('tickets')
                ->where('id', $ticket)
                ->first();

            notification::create([

                'user_id' => $leader_id,
                'title' => $ticketdetail->subject,
                'description'  => $ticketdetail->description,
                'tickets_id' => $ticket,
                'is_read' => 0

            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => "admin assign ticket to Team Leader",
                'old_value' => 'Unassigned',
                'new_value' => $leader->name,
                'ticket_id' => $ticket
            ]);

            
            TicktAssignjob::dispatch(
                $ticketdetail,
                $leader->email
            );


        }

        return back()
            ->with('success', 'Tickets assigned successfully');
    }


    // public function updateStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:open,in_progress,pending,resolved,closed'
    //     ]);
    //     $data=ticket::findOrFail($id);

    //      ActivityLog::create([
    //             'user_id'=> auth()->id(),
    //             'action' => 'Ticket status updated by admin',
    //             'old_value' => $data->status,
    //             'new_value'=>$request->status,
    //             'ticket_id' =>$data->id
    //         ]);


    //     DB::table('tickets')
    //         ->where('id', $id)
    //         ->update([
    //             'status' => $request->status,
    //             'updated_at' => now()
    //         ]);

    //     return redirect()->back();
    // }



    public function deleteTicket($id)
    {
        $ticket = ticket::findOrFail($id);


        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ticket is deleted',
            'old_value' => $ticket->subject,
            'new_value' => null,
            'ticket_id' => $ticket->id
        ]);


        $ticket->delete();

        return back()
            ->with('success', 'Ticket deleted successfully');
    }


    public function index(Request $request)
    {
        $query = ticket::with('assign');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('subject', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $query->orderBy('created_at', 'desc');

        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;

        $total = $query->count();

        $rows = $query->offset($offset)
            ->limit($limit)
            ->get();


        return response()->json([
            'total' => $total,
            'rows' => $rows
        ]);
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,pending,resolved,closed'
        ]);

        $ticket = ticket::findOrFail($id);


        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => "Status changed by admin",
            'old_value' => $ticket->status,
            'new_value' => $request->status,
            'ticket_id' => $ticket->id

        ]);

        $ticket->status = $request->input('status');

        $ticket->save();

        return redirect()->back()
            ->with('success', 'Ticket status updated!');
    }


    public function ticketCount()
    {
        $total = ticket::count();

        $openTicketsCount = ticket::where('status', 'open')->count();

        $closeTicketsCount = ticket::where('status', 'closed')->count();

        $pendingTicketsCount = ticket::where('status', 'pending')->count();

        $progressTicketsCount = ticket::where('status', 'in_progress')->count();

        $resolvedTicketsCount = ticket::where('status', 'resolved')->count();

        $salbreachTickets = ticket::where('status', '!=', 'closed')->where('sla_deadline', '<', now())->count();


        return view(
            'admin.Dashboard',
            compact(
                'total',
                'openTicketsCount',
                'closeTicketsCount',
                'pendingTicketsCount',
                'progressTicketsCount',
                'resolvedTicketsCount',
                'salbreachTickets'
            )
        );
    }
}
