<?php


namespace Infrastructure\Cache;

use Application\Interfaces\Infrastructure\Cache\CacheInterface;
use React\Promise\PromiseInterface;

class Cache implements CacheInterface
{
    private array $drivers  = [];
    private ?string $current = null;
    private ?string $default = null ;

    public function __construct()
    {
        $this->default = config("cache.driver","redis");
    }

    public function store($store)
    {
        $this->current = $store;
        return $this->getDriver();
    }

    public function set( $key, $value = null, $expiration = null )
    {
        $driver = $this->getDriver();
        $driver->set($key,$value,$expiration);
    }

    public function get($key,$default = null) : PromiseInterface
    {
        $driver = $this->getDriver();
        return $driver->get($key,$default);
    }

    private function getDriver()
    {
        if (is_null($this->current))
        {
            return $this->drivers[$this->current = $this->default] = Factory::createDriver($this->current);
        }

        return $this->drivers[$this->current];
    }

}