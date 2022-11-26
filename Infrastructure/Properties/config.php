<?php

return [
    "cache" => [
        "driver" => envGet("CACHE_DRIVER","redis"),
        "prefix" => envGet("CACHE_PREFIX","todolist"),

        "redis" => [
            "host"      => envGet("REDIS_HOST","localhost"),
            "port"      => envGet("REDIS_PORT"),
            "password"  => envGet("REDIS_PASSWORD"),
            "cluster"   => 0
        ]
    ],

    "filesystem" => [
        "driver" => envGet("FILESYSTEM_DRIVER","local"),
    ],

    "socket" => [
        "socket_server" => envGet("SOCKET_SERVER","127.0.0.1"),
        "socket_port"   => envGet("SOCKET_PORT","3000"),
    ]
];