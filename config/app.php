<?php

return [
    "name" => env("APP_NAME","Test"),

    "env" => env("APP_ENV","local"),

    "url" => env("APP_URL","http://127.0.0.1/"),

    "timezone" => "UTC",

    "socket_server" => env("SOCKET_SERVER","127.0.0.1"),
    "socket_port" => env("SOCKET_PORT","3000"),

    "middlewares" => [
        "test" => \App\Middlewares\TestMiddleware::class
    ]
];