<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\PullCategories;
use App\Models\Category;
use App\Models\SyncTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index () {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => Category::paginate(),
            'activeSync' => (SyncTransaction::where('status', 'running')->count() > 0)
        ]);
    }

    public function create () {
        return Inertia::render('Admin/Categories/Create');
    }

    public function pull (Request $request) {
        PullCategories::dispatch($request->user());

        // Create the lock to disable the Sync Job being submitted again
        SyncTransaction::create([
            'user_id' => $request->user()->id,
            'status' => 'running',
            'data' => [
                'message' => "Pull sync started by ".$request->user()->name,
                'sync_type' => 'pull',
                'started_at' => now(),
                'ended_at' => null,
            ]
        ]);

        return back()->with('message', [
            'type' => 'success',
            'message' => 'Process initiated! Categories are being pulled in the background.'
        ]);
    }
}
