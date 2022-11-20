<?php


namespace Common\Logger;

use Monolog\Handler\AbstractHandler;
use Monolog\Logger;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;

class Log implements LoggerInterface
{
    protected ?Logger $logger = null;

    public function __construct()
    {
        $this->logger = new Logger(Logger::getLevelName(Logger::ERROR));
        $this->logger->pushHandler(new StreamHandler(__ROOT__.'/storage/logs/app.log', Logger::DEBUG));
        $this->logger->pushHandler(new FirePHPHandler());
    }

    public function error(string $message = "", $context = [])
    {
        $this->logger->error($message,$context);
    }

    public function info(string $message = "", $context = [])
    {
        $this->logger->info($message,$context);
    }

    public function warning(string $message = "", $context = [])
    {
        $this->logger->warning($message,$context);
    }

    public function critical(string $message = "", $context = [])
    {
        $this->logger->critical($message,$context);
    }
}