<?php


namespace Core\Cache\Driver;

use Application\Interfaces\Infrastructure\Cache\CacheDriverInterface;
use React\Promise\PromiseInterface;

class FileDriver implements CacheDriverInterface
{
    public function set($key, $value = null, $expire = null)
    {
        // TODO: Implement set() method.
    }

    public function get($key, $default = null): PromiseInterface
    {
        // TODO: Implement get() method.
    }
}