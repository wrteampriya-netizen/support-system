<?php

namespace App\Http\Controllers;
use App\Jobs\Ticktclosejob;
use Illuminate\Http\Request;
use App\Models\ticket;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\ticketCloseMail;
use Illuminate\Support\Facades\Mail;

class agentController extends Controller
{

    public function index()
    {
        $agentId = Auth::id();

        $tickets = ticket::where('agent_id', $agentId)
            ->orderBy('created_at', 'desc')
            ->get();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Viewed assigned tickets',
            'old_value' => null,
            'new_value' => 'Agent opened ticket list',
            'ticket_id' => null
        ]);

        return view('agent.create', compact('tickets'));
    }

    public function accept($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([


                'status' => 'in_progress',

                'updated_at' => now()
            ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Agent started work',
            'old_value' => 'open',
            'new_value' => 'in_progress',
            'ticket_id' => $id
        ]);

        return redirect()->back()
            ->with('success', 'Ticket accepted');
    }
    public function updateStatus(Request $request, $id)
{
    $ticket = ticket::findOrFail($id);

    $old = $ticket->status;
    $newstatus = $request->status;

    $ticket->status = $newstatus;
    $ticket->save();

    ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'Agent updated status',
        'old_value' => $old,
        'new_value' => $newstatus,
        'ticket_id' => $id
    ]);

    if ($newstatus === 'closed') {

       
        $user = User::find($ticket->customer_id);

        if ($user) {
            Ticktclosejob::dispatch(
                $ticket->toArray(),
                $user->email
            );
        }
    }

    

    return redirect()->back()
        ->with('success', 'Ticket updated');
}





    public function chat($customer_id)
    {
        return view(
            'agent.chatsection',
            compact('customer_id')
        );
    }



    public function addComment(Request  $request, $id)
    {
        $comment = $request->comment;

        $ticket = ticket::findOrfail($id);

        if (!empty($ticket->comments)) {

            $ticket->comments =
                $ticket->comments . "\n" . $comment;
        } else {

            $ticket->comments = $comment;
        }



        if ($ticket->status == 'pending') {

            $ticket->status = 'in_progress';
        }

        $ticket->save();
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Comment added',
            'old_value' => null,
            'new_value' => $comment,
            'ticket_id' => $id
        ]);

        return redirect()->back();
    }



    public function getcomment()
    {
        $comment = DB::table('tickets')
            ->where('agent_id', auth()->id())
            ->whereNotNull('comments')
            ->get();


        return view(
            'agent.comments',
            compact('comment')
        );
    }







   
}
