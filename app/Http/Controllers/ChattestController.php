<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChattestController extends Controller
{


    public function index()
    {
        $userId = auth()->id();

        $username = auth()->user();

        if ($username->hasRole('customer')) {

            $agentIds = DB::table('message')

                ->where('reciever_id', $userId)

                ->where('sender_id', '!=', $userId)

                ->pluck('sender_id')

                ->unique();

            $users = User::whereIn('id', $agentIds)

                ->role([
                    'Admin',
                    'Super Admin',
                    'Team Leader',
                    'Support Agent'
                ])

                ->get();
        }
        
        else {

            $users = User::role([
                'Support Agent',
                'Team Leader',
                'Super Admin'
            ])
                ->where('id', '!=', $userId)
                ->get();

            foreach ($users as $user) {

                $user->unread_count = message::where('sender_id', $user->id)

                    ->where('reciever_id', $userId)

                    ->where('is_read', 0)

                    ->count();

                     return view('chat.list', compact('users'));
            }
        }
    }
}
