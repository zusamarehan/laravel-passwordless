<?php

namespace App\Listeners;

use App\Events\LoginRequestEvent;
use App\MagicCredentials;
use App\Notifications\SendMagicCredentialsNotification;
use App\Support\Passwordless;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;

class GenerateMagicCredentailListener implements ShouldQueue
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
     * @param LoginRequestEvent $loginRequestEvent
     * @return void
     */
    public function handle(LoginRequestEvent $loginRequestEvent)
    {
        $passwordless = new Passwordless($loginRequestEvent->email);
        $user = $passwordless->getUser();
        $token = $passwordless->generateToken();
        $code = $passwordless->generateCode();

        $magic = new MagicCredentials;
        $magic->token = Hash::make($token);
        $magic->code = Hash::make($code);
        $magic->user_id = $user->id;
        $magic->save();

        $magic_link = $passwordless->generateURL();

        $user->notify(new SendMagicCredentialsNotification($magic_link, $code));

    }
}
