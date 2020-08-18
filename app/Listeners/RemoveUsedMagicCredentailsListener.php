<?php

namespace App\Listeners;

use App\Events\LoggedInEvent;
use App\MagicCredentials;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveUsedMagicCredentailsListener implements ShouldQueue
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
        MagicCredentials::query()
            ->where('user_id', $loggedInEvent->user_id)
            ->delete();
    }
}
