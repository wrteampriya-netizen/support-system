<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\ticketCloseMail;
use Illuminate\Support\Facades\Mail;

class agentController extends Controller
{

    public function index()
    {
        $agent_id = Auth::id();

        

        $tickets = DB::table('tickets')
            ->where('agent_id', $agent_id)

            
            ->where('status', 'open')
            ->get();

        
        $acceptedTickets = DB::table('tickets')
            ->where('agent_id', $agent_id)
            ->whereIn('status', [
                'in_progress',
                'pending',
                'resolved'
            ])
            ->get();

        return view(
            'agent.create',
            compact(
                'tickets',
                'acceptedTickets'
            )
        );
    }

   

    public function accept($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([

                
                'status' => 'in_progress',

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

                
                'agent_id' => null,

                'status' => 'open',

                'updated_at' => now()
            ]);

        return redirect()->back()
            ->with('success', 'Ticket rejected');
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

  

    public function pending($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([

                
                'status' => 'pending',

                'updated_at' => now()
            ]);

        return redirect()->back()
            ->with('success', 'Waiting for customer reply');
    }

    

    public function resolve($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([

                
                'status' => 'resolved',

                'updated_at' => now()
            ]);

        return redirect()->back()
            ->with('success', 'Ticket resolved');
    }

   

    public function close($id)
    {
        DB::table('tickets')
            ->where('id', $id)
            ->update([

                'status' => 'closed',

                'updated_at' => now()
            ]);

        $ticket = DB::table('tickets')
            ->where('id', $id)
            ->first();

        $user = DB::table('users')
            ->where('id', $ticket->customer_id)
            ->first();

        Mail::to($user->email)
            ->send(new ticketCloseMail($ticket));
    }
}