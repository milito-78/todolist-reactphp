<?php

use Core\Exceptions\ErrorHandler;
use Core\Response\JsonRequestDecoder;
use Core\Route\Router;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use React\Http\HttpServer;
use React\MySQL\Factory as Mysql;

require "vendor/autoload.php";

$env = \Dotenv\Dotenv::createImmutable(__DIR__,"../.env");
$env->load();

date_default_timezone_set(env("TIMEZONE"));

$container = new League\Container\Container();

$loop = React\EventLoop\Loop::get();

$container->add("loop" ,$loop);
$container->add("MysqlConnector" , new Mysql($loop));


$aliases = include_once "app/Http/Middleware/MiddlewareAlias.php";

\Core\Route\Route::alias($aliases);

\Core\Route\Route::init(
                            new \FastRoute\RouteCollector(new \FastRoute\RouteParser\Std() ,
                            new \FastRoute\DataGenerator\GroupCountBased())
                        );

require_once "routes/router.php";


$CorsOption =  function (\Psr\Http\Message\RequestInterface $request , callable $next){
    if (preg_match('/options/i',$request->getMethod()))
    {
        return json_no_content();
    }
    return $next($request);
};




$server =  new HttpServer($loop, $CorsOption, new ErrorHandler(), new JsonRequestDecoder(), new Router(\Core\Route\Route::getCollector()));


$socket = new \React\Socket\SocketServer(
    uri:"127.0.0.1:3000",
    context:[],
    loop:$loop
);

$server->listen($socket);

$logger = new Logger('errors');
$logger->pushHandler(new StreamHandler(__DIR__.'/../storage/logs/app.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());

$server->on("error" , function ($data)use( $logger ) {
    $logger->error(get_class($data) . ' ' . $data->getMessage());
});

return $loop;