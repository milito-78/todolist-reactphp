<?php


namespace Common\Logger;


interface LoggerInterface
{
    public function error(string $message = "",$context = []);

    public function info(string $message = "",$context = []);

    public function critical(string $message = "",$context = []);

    public function warning(string $message = "",$context = []);
}