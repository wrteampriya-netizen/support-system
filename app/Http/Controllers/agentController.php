<?php

namespace App\Http\Controllers;
use App\Jobs\Ticktclosejob;
use App\Jobs\ActivityLogJob;
use Illuminate\Http\Request;
use App\Models\ticket;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\ticketCloseMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class agentController extends Controller
{

    public function index()
    {
        $agentId = Auth::id();

        $tickets = ticket::where('agent_id', $agentId)
            ->orderBy('created_at', 'desc')
            ->get();

        
ActivityLogJob::dispatch(
            auth()->id(),
             'Viewed assigned tickets',
            null,
            'Agent opened ticket list',
             null
        );

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

        ActivityLogJob::dispatch(
            auth()->id(),
             'Agent started work',
            'open',
             'in_progress',
             $id
        );
          Cache::forget('admin_dashbored');
        Cache::forget('ticket_report');

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
    Cache::forget('admin_dashboard');
Cache::forget('ticket_report');

    ActivityLogJob::dispatch(
         auth()->id(),
        'Agent updated status',
         $old,
         $newstatus,
         $id
    );

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
        ActivityLogJob::dispatch(
           auth()->id(),
           'Comment added',
            null,
             $comment,
             $id
        );

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
