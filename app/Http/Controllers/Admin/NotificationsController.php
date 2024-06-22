<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function markallasread (Request $request) {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('message', [
            'type' => 'info',
            'message' => 'All notifications have been marked as read'
        ]);
    }
}
