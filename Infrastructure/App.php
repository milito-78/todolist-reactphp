<?php 

namespace Infrastructure;

use Application\Interfaces\Infrastructure\DI\DependencyResolverInterface;
use Infrastructure\Config\Config;
use Infrastructure\Cronjob\Cronjob;
use Infrastructure\DI\DependencyResolver;
use League\Container\DefinitionContainerInterface;

class App {
    static private ?Config $config = null;
    static private ?DependencyResolverInterface $di = null;
    static private ?DefinitionContainerInterface $container = null;

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

    public function getContainer(): DefinitionContainerInterface
    {
        return self::container();
    }
    public function init(DefinitionContainerInterface $container) {
        $this->setContainer($container);
        $container->addServiceProvider(new ServiceProvider());
        (new Cronjob)->init();
    }

    public static function make($class,$params = []):mixed{
        return self::di()->make($class,$params);
    }

    private static function di(){
        if(self::$di)
            return self::$di;
        return self::$di = new DependencyResolver(self::container());
    }

    public static function path()
    {
        return __DIR__;
    }
}