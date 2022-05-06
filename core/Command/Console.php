<?php


namespace Core\Command;


class Console
{
    public function commands(): array
    {
        return [
            MakeController::class,
            MakeMiddleware::class,
            MakeModel::class,
            MakeRequest::class,
            MakeMigrationCommand::class,
        ];
    }
}