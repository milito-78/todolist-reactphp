<?php
namespace Service\Shared\Listeners;

class ErrorHandlerEvent
{
    public function __invoke($exception)
    {
        \Common\Logger\LoggerFacade::error($exception->getMessage(),["exception" => $exception]);
    }
}