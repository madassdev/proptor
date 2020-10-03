<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return redirect($notification->data['redirect_url']);

    }

    public function readAll()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->back()->withSuccess('Notifications cleared!');
    }
}
