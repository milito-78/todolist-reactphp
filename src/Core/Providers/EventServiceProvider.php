<?php


namespace App\Core\Providers;

use App\Core\Events\DeleteFileEvent;
use App\Core\Events\ErrorHandlerEvent;
use App\Core\Events\SendEmailVerificationCodeEvent;
use App\Core\Events\UploadCleanerEvent;
use Core\Providers\EventServiceProvider as Provider;
class EventServiceProvider extends Provider
{
    protected array $server_events = [
        "error"                     => ErrorHandlerEvent::class,
        "upload_clean"              => UploadCleanerEvent::class,
        "delete_file"               => DeleteFileEvent::class,
        "send_verify_code_email"    => SendEmailVerificationCodeEvent::class,
    ];

    protected array $events = [

    ];
}