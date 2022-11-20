<?php

use Service\Middlewares\AuthMiddleware;

return [
    "name" => envGet("APP_NAME","Test"),

    "env" => envGet("APP_ENV","local"),

    "url" => envGet("APP_URL","http://127.0.0.1/"),

    "timezone" => "UTC",

    "socket_server" => envGet("SOCKET_SERVER","127.0.0.1"),
    "socket_port" => envGet("SOCKET_PORT","3000"),

    "middlewares" => [
        'auth' => AuthMiddleware::class,
    ],
];