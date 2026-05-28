<?php

namespace App\Http\Controllers;

use App\Models\message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\User;

class messageController extends Controller
{
    //
    // public function index()
    // {
    //     $userId = auth()->id();
    //     $chats = DB::table('message')
       
    //         ->where('reciever_id', $userId)
    //         ->orderby('created_at', 'desc')
    //         ->get();

    //     return view('agent.index', compact('chats'));
    // }
//     
// public function index()
// {
//     $userId = auth()->id();

//     $senders = DB::table('message')
//         ->where('reciever_id', $userId)
//         ->select('sender_id')
//         ->distinct()
//         ->get();

//     foreach ($senders as $sender) {

//         $sender->unread = DB::table('message')
//             ->where('sender_id', $sender->sender_id)
//             ->where('reciever_id', $userId)
//             ->where('is_read', 0)
//             ->count();
//     }
    


//     return view('agent.index', [
//         'chats' => $senders
//     ]);
// }
  public function index()
    {
        $userId = auth()->id();

        $chats = DB::table('message')
            ->where('reciever_id', $userId)
            ->select('sender_id')
            ->distinct()
            ->get();

        foreach ($chats as $chat) {

            $chat->unread = DB::table('message')
                ->where('sender_id', $chat->sender_id)
                ->where('reciever_id', $userId)
                ->where('is_read', 0)
                ->count();
        }

        return view('agent.index', compact('chats'));
    }


    public function openchat($id)
{
    $userId = auth()->id();

    $user = User::findOrFail($id);

    
    $message = DB::table('message')
        ->where('sender_id', $userId)
        ->where('reciever_id', $id)

        ->orWhere('sender_id', $id)
        ->where('reciever_id', $userId)

        ->get();

    
    DB::table('message')
        ->where('sender_id', $id)
        ->where('reciever_id', $userId)
        ->update([
            'is_read' => 1
        ]);

  
    $unread = DB::table('message')
        ->where('reciever_id', $userId)
        ->where('is_read', 0)
        ->count();

    return view('agent.openchat',
        compact('message', 'user', 'id', 'unread')
    );
}

    public function sendmsg(Request $request)
    {
        DB::table('message')->insert([
            'sender_id' => auth()->id(),
            'reciever_id' => $request->reciever_id,
            'message' => $request->message,
            'is_read'     => 0,
            'created_at' => now(),
            'updated_at' => now()



        ]);
        return back();
    }

     public function chat($customer_id)
{
    return view('agent.chat', compact('customer_id'));
}

    
}
