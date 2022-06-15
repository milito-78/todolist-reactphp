<?php


namespace App\Core\Providers;

use App\Core\Events\ErrorHandlerEvent;
use Core\Providers\EventServiceProvider as Provider;
class EventServiceProvider extends Provider
{
    protected array $server_events = [
        "error" => ErrorHandlerEvent::class
    ];

    protected array $events = [

    ];
}