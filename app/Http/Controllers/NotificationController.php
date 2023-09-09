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
        $notifications = $user->notifications;

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

}
