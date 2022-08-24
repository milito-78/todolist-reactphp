<?php

use App\Core\Providers\EventServiceProvider;
use App\Core\Repositories\UploadRepositoryInterface;
use React\Filesystem\Factory;
use React\Http\Middleware\StreamingRequestMiddleware;
use React\Http\Middleware\RequestBodyBufferMiddleware;
use React\Http\Middleware\RequestBodyParserMiddleware;
use Core\Route\Middleware\CorsMiddleware;
use Core\Route\Middleware\JsonResponseMiddleware;
use Core\{
    Exceptions\ErrorHandler,
    Route\RouteFacade,
    StaticFiles\StaticFileController,
    Response\JsonRequestDecoder};
use Core\DI\DependencyResolver;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use React\Http\HttpServer;
use React\Socket\SocketServer;


//////////////////////
use Core\Route\RouteCollector as Router;

date_default_timezone_set(config("app.timezone"));

$loop = React\EventLoop\Loop::get();


$routeCollector = new RouteCollector( new Std() ,new GroupCountBased() );
$container->add(RouteCollector::class,$routeCollector);
$filesystem = Factory::create();

RouteFacade::get('/storage/public/{file}',StaticFileController::class);

require_once "routes/router.php";


$server =  new HttpServer(
    $loop,
    new StreamingRequestMiddleware(),
    new RequestBodyBufferMiddleware(8 * 1024 * 1024), // 8 MiB
    new RequestBodyParserMiddleware(8 * 1024 * 1024, 1), // 8 MiB
    new CorsMiddleware(),
    new ErrorHandler(),
    new JsonRequestDecoder(),
    new JsonResponseMiddleware(),
    new Router($routeCollector,new DependencyResolver),
);

$socket = new SocketServer(
     config("app.socket_server") . ":" . config("app.socket_port"),
    [],
    $loop
);

$server->listen($socket);

$logger = new Logger('errors');
$logger->pushHandler(new StreamHandler(__DIR__.'/../storage/logs/app.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());


$container->add("logger" , $logger);


$event = new EventServiceProvider();
$event->register();

$loop->addPeriodicTimer(60,function (){
    /** @var UploadRepositoryInterface $uploadRepository */
    $uploadRepository = container()->get(UploadRepositoryInterface::class);
    echo "Remove extra files cron job. Starts at : " . date("Y-m-d H:i:s") . "\n";

    $uploadRepository->getExpiredFiles()->then(function ($images) use ($uploadRepository){
        foreach ($images as $image)
        {

            $uploadRepository->delete($image["id"])->then(function ($res) use($image){
                echo $image["id"] . " photo delete from database status : " . ($res? "true" : "false") . "\n";
            });
        }
    });

});

return $loop;