<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployeeHasShowroom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(is_null($request->user()->showroom_id)) {
            Auth::guard('web')->logout();

            return redirect(route('login'))->with('message', [
                'type' => 'info',
                'message' => 'You have not ben assigned any showroom. Please contact the admin if you think this is a problem'
            ]);
        }
        
        return $next($request);
    }
}
