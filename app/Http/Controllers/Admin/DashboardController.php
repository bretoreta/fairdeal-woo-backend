<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SyncTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Dashboard', [
            'activeSync' => (SyncTransaction::where('status', 'running')->count() > 0),
            'syncable' => (Product::where('sync_status', 'notsynced')->count() > 0),
            'statsData' => [
                'totalProducts' => Product::all()->count(),
                'waitingSyncProducts' => Product::where('sync_status', 'notsynced')->count(),
                'syncedProducts' => Product::where('sync_status', 'synced')->count(),
            ],
            'notifications' => $request->user()->notifications,
            'syncTransactions' => SyncTransaction::whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])->latest()->get(),
        ]);
    }
}
