<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClientRegistrationNotification;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function get_all_notifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return response()->json(['notifications' => $notifications]);
    }

    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();
        $notification = $user->notifications->find($id);

        if ($notification) {
            $notification->markAsRead();
            // Optionally, you can also update the 'read_at' timestamp manually:
            // $notification->read_at = now();
            // $notification->save();
        }

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function getNotificationCount(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications->where('read_at',null);
        $notificationCount = $notifications->count();

        return response()->json(['notificationCount' => $notificationCount]);
    }


}
