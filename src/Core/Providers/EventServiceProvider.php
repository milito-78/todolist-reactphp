<?php


namespace App\Core\Providers;

use App\Core\Events\ErrorHandlerEvent;
use App\Core\Events\UploadCleanerEvent;
use Core\Providers\EventServiceProvider as Provider;
class EventServiceProvider extends Provider
{
    protected array $server_events = [
        "error"         => ErrorHandlerEvent::class,
        "upload_clean"  => UploadCleanerEvent::class
    ];

    protected array $events = [

    ];
}