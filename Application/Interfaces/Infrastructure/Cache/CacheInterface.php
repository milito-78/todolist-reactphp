<?php 
namespace Application\Interfaces\Infrastructure\Cache;

use React\Promise\PromiseInterface;

interface CacheInterface{

    public function store($store);

    public function set( $key, $value = null, $expiration = null );

    public function get($key,$default = null) : PromiseInterface;

}