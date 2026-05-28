<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChattestController extends Controller
{
// public function index()
// {
//     $userId = auth()->id();

//     $user = auth()->user();

//     // CUSTOMER LOGIN
//     if ($user->hasRole('Customer')) {

//         $senderIds = DB::table('message')
//             ->where('reciever_id', $userId)
//             ->pluck('sender_id')
//             ->unique();

//         $users = User::whereIn('id', $senderIds)
//             ->role([
//                 'Admin',
//                 'Super Admin',
//                 'Team Leader',
//                 'Support Agent'
//             ])
//             ->get();
//     }

//     // STAFF LOGIN
//     else {

//         $users = User::role([
//             'Admin',
//             'Super Admin',
//             'Team Leader',
//             'Support Agent'
//         ])
//         ->where('id', '!=', $userId)
//         ->get();
//     }

//     return view('agent.index', compact('users'));
// }

}
