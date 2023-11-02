<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Notifications;

class NotifController extends Controller
{
    public function showNotifications()
    {
        $notifications = Auth::user()->notifications;

        $title = 'Notifications';

        return view('notif_page', compact('notifications', 'title'));
    }

    public function deleteNotif($id)
    {
        Notifications::where('id', $id)->delete();
        return back();
    }

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications->where('id', $notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }
}
