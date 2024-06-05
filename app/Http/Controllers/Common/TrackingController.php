<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Jetstream\Agent;

class TrackingController extends Controller
{
    public function register(Request $request, User $user, $socialmedia)
    {
        // Check if browser user agent is bot, redirect to bad traffic url
        $agent = $this->createAgent($request);
        if($agent->isRobot()) {
            return Inertia::location(config('app.bad_traffic_url', 'https://fairdealfurniture.co.ke'));        
        }
        else {
            if(in_array($socialmedia, ['facebook', 'whatsapp', 'tiktok', 'linkedin', 'instagram', 'youtube'])) {
                if(Click::where('socialmedia', $socialmedia)->where('user_id', $user->id)->where('ip_address', $request->ip())->whereDay('created_at' , '=', now()->format('d'))->count() == 0) {
                    // Do nothing if request is coming from our IP
                    if($request->ip() !== config('app.our_ip')) {
                        $this->createClick($user, $request, $socialmedia);
                    }
                }
                
                if($socialmedia == 'whatsapp') {
                    $user->load('showroom');
                    $phone = $user->showroom->phone;
                    $name = $user->name;

                    return Inertia::location("https://wa.me/{$phone}?text=Can%20I%20speak%20to%20{$name}%20please");
                }

                return Inertia::location(config("app.links.{$socialmedia}", 'https://fairdealfurniture.co.ke'));
            }

            return Inertia::location(config('app.bad_traffic_url', 'https://fairdealfurniture.co.ke'));
        }
    }

    private function createClick(User $user, Request $request, $socialmedia)
    {
        return Click::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'socialmedia' => $socialmedia,
            'http_referer' => request()->headers->get('referer'),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
        ]);
    }

    /**
     * Create a new agent instance from the given request.
     *
     * @param  Request  $request
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent(Request $request)
    {
        return tap(new Agent(), fn ($agent) => $agent->setUserAgent($request->userAgent()));
    }
}
