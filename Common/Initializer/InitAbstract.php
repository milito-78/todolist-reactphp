<?php 

namespace Common\Initializer;
use Infrastructure\Config\Config;
use League\Container\DefinitionContainerInterface;

abstract class InitAbstract {
    static private ?Config $config = null;

    public function __construct()
    {
        self::getConfigInstance();
    }


    static public function getConfigInstance(){
        if(self::$config)
            return self::$config;

        self::$config = new Config();
        self::$config->loadConfigurationFiles('/Properties',envGet("APP_ENV","local"));

        return self::$config;
    }

    static public function config(string $key, $default = null)
    {
        return self::getConfigInstance()->get($key,$default);
    }

    abstract public function init (DefinitionContainerInterface $container);
}