<?php

return [
    "name" => envGet("APP_NAME","Test"),

    "env" => envGet("APP_ENV","local"),

    "url" => envGet("APP_URL","http://127.0.0.1/"),

    "timezone" => "UTC",

    "socket_server" => envGet("SOCKET_SERVER","127.0.0.1"),
    "socket_port" => envGet("SOCKET_PORT","3000"),

    "middlewares" => [

    ],

    "providers" => [
        \Core\Providers\AppServiceProvider::class,
        \App\Core\Providers\RepositoryServiceProvider::class,
        \App\Core\Providers\ControllerServiceProvider::class,
    ]
];