<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClientRegistrationNotification;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function get_all_notifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications;

        return response()->json(['notifications' => $notifications]);
    }

}
