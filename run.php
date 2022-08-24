<?php

require "vendor/autoload.php";

use Dotenv\Dotenv;

const __ROOT__ = __DIR__;


if (!function_exists("envGet"))
{
    function envGet(string $key,$default = null)
    {
        return $_ENV[$key]??$default;
    }
}


$env = Dotenv::createImmutable(__DIR__,".env");
$env->load();

$container = new League\Container\Container();


$application = new \Application\App();
$application->init($container);

$infrastructure = new \Infrastructure\App();
$infrastructure->init($container);

$persistence = new \Persistence\App();
$persistence->init($container);