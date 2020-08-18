<?php

namespace App\Providers;

use App\Events\LoggedInEvent;
use App\Events\LoginRequestEvent;
use App\Listeners\GenerateMagicCredentailListener;
use App\Listeners\RemoveUsedMagicCredentailsListener;
use App\Listeners\StoreUserCookieListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LoginRequestEvent::class => [
            GenerateMagicCredentailListener::class
        ],
        LoggedInEvent::class => [
            RemoveUsedMagicCredentailsListener::class,
            StoreUserCookieListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
