<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\BugReportNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BugsreportController extends Controller
{
    public function send (Request $request) {
        try {
            $request->validate([
                'email' => 'required|string|max:255|email:rfc,dns,filter',
                'subject' => 'required|string|max:255',
                'message' => 'required|string:max:2048'
            ]);

            $admins = User::role('admin')->get();

            Notification::send($admins, new BugReportNotification($request->email, $request->subject, $request->message));

            return back()->with('message', [
                'type' => 'success',
                'message' => 'Support Message Sent. We will contact you soon.'
            ]);
        } catch (\Error $error) {
            return back()->with('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }
    }
}
