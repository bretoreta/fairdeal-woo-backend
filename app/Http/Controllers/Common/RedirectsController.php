<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectsController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->hasRole('admin'))
        {
            return redirect()->route('admin.dashboard');
        }
        else if($request->user()->hasRole('user'))
        {
            return redirect()->route('user.dashboard');
        }
        else if($request->user()->hasRole('employee'))
        {
            return redirect()->route('employee.dashboard');
        }
        else if($request->user()->hasRole('salesperson'))
        {
            return redirect()->route('sales.dashboard');
        }
        else {
            return redirect('/');
        }
    }
}
