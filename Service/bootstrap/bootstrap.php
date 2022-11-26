<?php

use Infrastructure\DI\DependencyResolver;
use React\Http\Middleware\StreamingRequestMiddleware;
use React\Http\Middleware\RequestBodyBufferMiddleware;
use React\Http\Middleware\RequestBodyParserMiddleware;
use Service\App;
use Service\Shared\Route\Middleware\CorsMiddleware;
use Service\Shared\Route\Middleware\JsonResponseMiddleware;
use Service\Shared\{
    Exceptions\ErrorHandler,
    Route\RouteFacade,
    StaticFiles\StaticFileController,
    Response\JsonRequestDecoder};
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use React\Http\HttpServer;


//////////////////////
use Service\Shared\Route\RouteCollector as Router;

date_default_timezone_set(App::config("config.timezone"));

$loop           = React\EventLoop\Loop::get();

$routeCollector = new RouteCollector( new Std() ,new GroupCountBased() );

$container = App::container();

$container->add(RouteCollector::class,$routeCollector);


RouteFacade::get('/storage/public/{file}',StaticFileController::class);

require_once "router.php";

$server =  new HttpServer(
    $loop,
    new StreamingRequestMiddleware(),
    new RequestBodyBufferMiddleware(8 * 1024 * 1024), // 8 MiB
    new RequestBodyParserMiddleware(8 * 1024 * 1024, 1), // 8 MiB
    new CorsMiddleware(),
    new ErrorHandler(),
    new JsonRequestDecoder(),
    new JsonResponseMiddleware(),
    new Router($routeCollector,new DependencyResolver($container)),
);

$socket = App::container()->get("SocketSystem");

$server->listen($socket);

$server->on("error", function ($exception){
    \Common\Logger\LoggerFacade::error($exception->getMessage(),["exception" => $exception]);
});

$container->add("HttpServer" , $server);

return $loop;