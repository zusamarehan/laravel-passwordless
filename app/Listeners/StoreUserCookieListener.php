<?php

namespace App\Listeners;

use App\Events\LoggedInEvent;
use App\UserLoginCookies;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;

class StoreUserCookieListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param LoggedInEvent $loggedInEvent
     * @return void
     */
    public function handle(LoggedInEvent $loggedInEvent)
    {
        $userLoginCookie = new UserLoginCookies;
        $userLoginCookie->user_id = $loggedInEvent->user_id;
        $userLoginCookie->cookie = Hash::make($loggedInEvent->cookie);
        $userLoginCookie->expires_at = now()->addDays(30);
        $userLoginCookie->save();
    }
}
