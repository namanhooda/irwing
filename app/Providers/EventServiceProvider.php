<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use App\Listeners\SetDefaultRoleOnLogin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
    \Illuminate\Auth\Events\Login::class => [
        \App\Listeners\SetDefaultRoleOnLogin::class,
    ],
];
}
