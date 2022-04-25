<?php

use App\Middlewares\CorsMiddleware;
use App\Middlewares\JsonResponseMiddleware;
use Core\ {
    Config\Config,
    Exceptions\ErrorHandler,
    Response\JsonRequestDecoder,
    Route\Route,
    Route\Router,
};

use Dotenv\Dotenv;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\RequestInterface;
use React\Http\HttpServer;
use React\Socket\SocketServer;

$env = Dotenv::createImmutable(__DIR__,"../.env");
$env->load();

$config = new Config();
$config->loadConfigurationFiles(__DIR__ . '/../config',envGet("APP_ENV","local"));

date_default_timezone_set(config("app.timezone"));

$container = new League\Container\Container();

$loop = React\EventLoop\Loop::get();

$providers = \config("app.providers");

foreach ($providers as $provider){
    $container->addServiceProvider(new $provider());
}



Route::alias(config("app.middlewares"));

Route::init(
                new RouteCollector(new Std() ,
                new GroupCountBased())
           );

require_once "routes/router.php";


$server =  new HttpServer(
    $loop,
    new CorsMiddleware(),
    new ErrorHandler(),
    new JsonRequestDecoder(),
    new JsonResponseMiddleware(),
    new Router(Route::getCollector()),
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

$server->on("error" , function ($data)use( $logger ) {
    $logger->error(get_class($data) . ' ' . $data->getMessage(),["trace" => $data]);
});

return $loop;