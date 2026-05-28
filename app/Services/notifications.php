<?php

namespace App\Services;

use App\Models\notification;

class notifications
{
    public function baseQuery()
    {
        if (!auth()->check()) {
            return notification::query()->whereRaw('1 = 0');
        }
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return notification::query();
        }
        if ($user->hasRole('Team Leader')) {
            return notification::where('user_id', $user->id);
        }

        if ($user->hasRole('Support Agent')) {
            return notification::where('user_id', $user->id);
        }
        return notification::where('user_id', $user->id);
    }

    //     public function open($id)
    // {
    //     $notification = notification::findOrFail($id);

    //     $notification->update([
    //         'is_read' => 1
    //     ]);

    //     return back();
    // }
    public function open($id)
    {
        $notification = notification::findOrFail($id);

        $notification->update([
            'is_read' => 1
        ]);

        return redirect()->route('admin.fetch');
    }
    public function unreadCount()
    {
        return $this->baseQuery()
            ->where('is_read', 0)
            ->count();
    }

    //    public function latestNotifications()
    // {
    //     return $this->baseQuery()
    //         ->where('is_read', 0)   
    //         ->latest()
    //         ->take(5)
    //         ->get();
    // }
    public function latestNotifications()
    {
        return $this->baseQuery()
            ->where('is_read', 0)
            ->latest()
            ->take(5)
            ->get();
    }
}
