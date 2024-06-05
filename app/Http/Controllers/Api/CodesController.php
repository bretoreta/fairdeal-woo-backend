<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Code;
use Illuminate\Http\Request;

class CodesController extends Controller
{
    public function index (Request $request) {
        $request->validate([
            'search' => 'string|max:255'
        ]);

        return Code::where('token', 'like',  '%'. strtolower($request->query('search')) .'%')
                    ->where(function($q) {
                        return $q->where('is_used', false)->orWhere('redeemed_at', null);
                    })
                    ->with('owner:id,name')
                    ->get()->toJson();
    }
}
