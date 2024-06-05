<?php

namespace App\Http\Controllers\Employees;

use App\Http\Controllers\Controller;
use App\Models\Code;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $redeemed_codes = Code::whereBetween('redeemed_at', [now()->startOfWeek()->subWeeks(2), now()->endOfWeek()])->get();
        $new_codes = Code::whereBetween('created_at', [now()->startOfWeek()->subWeeks(2), now()->endOfWeek()])->get();
        $new_customers = User::role('user')->where('showroom_id', $request->user()->showroom_id)->whereBetween('created_at', [now()->startOfWeek()->subWeeks(2), now()->endOfWeek()])->get();

        $data = [
            'redeemedCodes' => [
                'thisWeek' => $redeemed_codes->whereBetween('redeemed_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'lastWeek' => $redeemed_codes->whereBetween('redeemed_at', [now()->startOfWeek()->subWeeks(1), now()->startOfWeek()])->count(),
            ],
            'newCodes' => [
                'thisWeek' => $new_codes->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'lastWeek' => $new_codes->whereBetween('created_at', [now()->startOfWeek()->subWeeks(1), now()->startOfWeek()])->count(),
            ],
            'newCustomers' => [
                'thisWeek' => $new_customers->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'lastWeek' => $new_customers->whereBetween('created_at', [now()->startOfWeek()->subWeeks(1), now()->startOfWeek()])->count(),
            ]
        ];

        $request->user()->load('showroom');

        return Inertia::render('Employees/Dashboard', [
            'dashboardData' => $data,
            'latestData' => $redeemed_codes->load('owner:id,name,email'),
        ]);
    }
}
