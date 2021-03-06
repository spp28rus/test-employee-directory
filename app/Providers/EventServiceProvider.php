<?php

namespace App\Providers;

use App\Events\EmployeeSkillCreatingEvent;
use App\Listeners\EmployeeSkillCreatingListener;
use App\Listeners\RegisteredUserEmployeeListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
            RegisteredUserEmployeeListener::class,
        ],
        EmployeeSkillCreatingEvent::class => [
            EmployeeSkillCreatingListener::class,
        ],
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
