<?php

namespace App\Listeners;

use App\Events\LoginRequestEvent;
use App\MagicCredentials;
use App\Notifications\SendMagicCredentialsNotification;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
        $user = User::query()
            ->findUserByEmail($loginRequestEvent->email)
            ->first();

        $token = Str::random(25).uniqid().Str::random(26);
        $code = mt_rand(1000,9999).'-'.mt_rand(1000,9999);
        $magic = new MagicCredentials;
        $magic->token = Hash::make($token);
        $magic->code = Hash::make($code);
        $magic->user_id = $user->id;
        $magic->save();

        $magic_link = URL::temporarySignedRoute('login.authenticate.email', now()->addMinutes(1), [
            'token' => $token
        ]);

        $user->notify(new SendMagicCredentialsNotification($magic_link, $code));

    }
}
