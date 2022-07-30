<?php


namespace Core\Cache\Driver;


use React\Promise\PromiseInterface;

interface DriverInterface
{
    public function set($key,$value = null, $expire = null);

    public function get($key,$default = null) : PromiseInterface;
}