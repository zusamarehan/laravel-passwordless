<?php

namespace App\Http\Middleware;

use App\Events\LoggedInEvent;
use App\Support\Passwordless;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class FreshCookies
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(request()->filled('token')) {
            if(!request()->hasValidSignature()) {
                return response()->json(['error' => 'The link has expired'], 400);
            }
        }

        if(!request()->filled('token') && !request()->filled('code')) {
            return response()->json(['error' => 'Something went wrong'], 400);
        }

        $verified = Passwordless::verify();

        if(!$verified) {
            return response()->json(['message' => 'The Token is not valid or it has been expired'], 422);
        }

        $cookie = base64_encode($verified->token.uniqid().$verified->code);
        // this event's listener is synced not queued
        event(new LoggedInEvent($verified->user_id, $cookie));

        return $next($request)
            ->cookie(new Cookie('pudding_v2Cookie', $cookie, now()->addDays(30)));
    }
}
