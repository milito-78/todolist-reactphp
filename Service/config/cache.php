<?php
return [

    "driver" => envGet("CACHE_DRIVER","redis"),
    "prefix" => envGet("CACHE_PREFIX","todolist"),

    "redis" => [
        "host" => envGet("REDIS_HOST","localhost"),
        "port" => envGet("REDIS_PORT"),
        "password" => envGet("REDIS_PASSWORD"),
        "cluster" => 0
    ]
];