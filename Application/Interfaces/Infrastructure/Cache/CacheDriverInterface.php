<?php

namespace Application\Interfaces\Infrastructure\Cache;


use React\Promise\PromiseInterface;

interface CacheDriverInterface
{
    public function set($key,$value = null, $expire = null);

    public function get($key,$default = null) : PromiseInterface;
}