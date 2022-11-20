<?php 

namespace Service;

use Infrastructure\Config\Config;
use League\Container\DefinitionContainerInterface;

class App {
    static private ?Config $config = null;
    static private ?DefinitionContainerInterface $container = null;
    static private ?\React\Http\HttpServer $server = null;
    static private ?\React\Socket\SocketServer $socket = null;

    public function __construct()
    {
        self::getConfigInstance();
    }


    static public function getConfigInstance(){
        if(self::$config)
            return self::$config;

        self::$config = new Config();
        self::$config->loadConfigurationFiles(static::path().'/Properties');

        return self::$config;
    }

    static public function config(string $key, $default = null)
    {
        return self::getConfigInstance()->get($key,$default);
    }

    protected function setContainer($container)
    {
        self::$container = $container;
    }

    static public function container() : DefinitionContainerInterface
    {
        if (self::$container)
            return self::$container;
        throw new \Exception("Container not ready for now. Please init before use it.");
    }

    static public function server() : \React\Http\HttpServer
    {
        if (self::$server)
            return self::$server;

        self::$server = self::container()->get("HttpServer");
        if (!self::$server)
            throw new \Exception("Server not ready for now. Please init before use it.");
        return self::$server;
    }

    static public function socket() : \React\Socket\SocketServer
    {
        if (self::$socket)
            return self::$socket;

        self::$socket = self::container()->get("HttpSocket");
        if (!self::$socket)
            throw new \Exception("Socket not ready for now. Please init before use it.");
        return self::$socket;
    }

    public function getContainer(): DefinitionContainerInterface
    {
        return self::container();
    }


    public function init(DefinitionContainerInterface $container) {
        $this->setContainer($container);
        $container->addServiceProvider(new ServiceProvider());
        include_once "server.php";
    }

    public static function path()
    {
        return __DIR__;
    }
}