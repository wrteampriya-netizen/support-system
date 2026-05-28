<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function open($id)
    {
        $notification = notification::findOrFail($id);


        $notification->update([
            'is_read' => 1
        ]);

        $user = Auth::user();

        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role == 'Team Leader') {
            return redirect()->route('leader.tickets', [
                'ticket_id' => $notification->tickets_id
            ]);
        }

        if ($user->role == 'Support Agent') {
            return redirect()->route('agent.showpage');
        }



        return back();
    }
}
