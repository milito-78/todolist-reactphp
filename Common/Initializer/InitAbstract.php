<?php 

namespace Common\Initializer;
use Infrastructure\Config\Config;
use League\Container\DefinitionContainerInterface;

abstract class InitAbstract {
    static private ?Config $config = null;
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

    abstract public function init (DefinitionContainerInterface $container);
    abstract public static function path();
}