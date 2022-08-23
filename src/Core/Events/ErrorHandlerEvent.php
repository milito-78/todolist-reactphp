<?php


namespace App\Core\Events;


class ErrorHandlerEvent
{
    public function __invoke($data)
    {
        $logger = container()->get("logger");
        $logger->error(get_class($data) . ' ' . $data->getMessage(),["trace" => $data]);
    }
}