<?php


namespace Core\Cache\Driver;


use Clue\React\Redis\Client;
use Clue\React\Redis\Factory;
use React\Promise\PromiseInterface;

class RedisDriver implements DriverInterface
{
    private Client $redis;

    public function __construct()
    {
        $loop = loop();

        $redisFactory = new Factory($loop);

        $this->redis = $redisFactory->createLazyClient($this->getRedisConfigUrl());
    }

    public function set($key, $value = null, $expire = null)
    {
        $key     = $this->keyGenerate($key);

        $this->redis->set($key,serialize($value));

        if (!is_null($expire)) {
            $this->redis->expire($key, $expire);
        }
    }

    public function get($key, $default = null) : PromiseInterface
    {
        $key    = $this->keyGenerate($key);
        return  $this->redis
                ->get($key)
                ->then(function ($result) use ($default) {
                    if (is_null($result) && !is_null($default)) {
                        $result = $default;
                    }
                    return unserialize($result);
                });
    }


    private function keyGenerate($key) :string
    {
        return $this->getPrefix() . $key;
    }
    private function getPrefix() : string
    {
        return config("cache.prefix") . ":";
    }

    private function getRedisConfigUrl():string
    {
        $url = 'redis://' . config("cache.redis.host") .':'. config("cache.redis.port");
        $query = ["db" => config("cache.redis.cluster",1)];

        if ($password = config("cache.redis.password")){
            $query["password"] = $password;
        }

        $url .= '?'. http_build_query($query);

        return $url;
    }
}