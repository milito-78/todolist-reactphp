<?php

require "vendor/autoload.php";

use Dotenv\Dotenv;
use Infrastructure\Socket\SocketFactory;
use React\Filesystem\Factory;


const __ROOT__ = __DIR__;


if (!function_exists("envGet"))
{
    function envGet(string $key,$default = null)
    {
        return $_ENV[$key]??$default;
    }
}

$loop           = React\EventLoop\Loop::get();

$env = Dotenv::createImmutable(__DIR__,".env");
$env->load();

$container = new League\Container\Container();

$filesystem = Factory::create();

$container->add("filesystem",$filesystem);

$socket = SocketFactory::create($loop);

$container->add("SocketSystem" , $socket);


$application = new \Application\App();
$application->init($container);


$persistence = new \Persistence\App();
$persistence->init($container);

$infrastructure = new \Infrastructure\App();
$infrastructure->init($container);

$webService = new \Service\App();
$webService->init($container);
