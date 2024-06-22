<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SyncProducts;
use App\Models\SyncTransaction;
use App\Models\User;
use App\Notifications\Admin\SyncStartedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function dispatch (Request $request) {

        // Fetch all admin users
        $admins = User::role('admin')->get();

        // Notify admins of the new Sync that has been started
        Notification::send($admins, new SyncStartedNotification($request->user()));

        // Dispatch Sync Job
        SyncProducts::dispatch($request->user());

        // Create the lock to disable the Sync Job being submitted again
        SyncTransaction::create([
            'user_id' => $request->user()->id,
            'status' => 'running',
            'data' => [
                'message' => "Push sync started by ".$request->user()->name,
                'sync_type' => 'push',
                'started_at' => now(),
                'ended_at' => null,
            ]
        ]);
        
        return back()->with('message', [
            'type' => 'success',
            'message' => 'Sync process initialized. The process is running in the background. We`ll notify admins when done.'
        ]);
    }
}
