<?php

namespace App\Http\Middleware;

use App\UserLoginCookies;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PuddingAuth
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
        $cookie = $request->cookie('pudding_v2Cookie');
        $verified = UserLoginCookies::query()
            ->get()
            ->where('expires_at', '>=', now())
            ->filter(function($magic) use ($cookie) {
                return Hash::check($cookie, $magic->cookie);
            })
            ->first();

        if(!$verified) {
            if (request()->wantsJson()) return response()->json('Unauthenticated', 401);
            return redirect('/');
        }

        Auth::onceUsingId($verified->user_id);
        return $next($request);
    }
}
