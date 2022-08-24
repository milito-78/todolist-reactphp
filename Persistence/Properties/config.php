<?php

return [
    "database" => [
        'default' => envGet('DB_CONNECTION', 'mysql'),

        "connections" => [
            'mysql' => [
                'driver' => 'mysql',
                'url' => envGet('DATABASE_URL'),
                'host' => envGet('DB_HOST', '127.0.0.1'),
                'port' => envGet('DB_PORT', '3306'),
                'database' => envGet('DB_DATABASE', 'forge'),
                'username' => envGet('DB_USERNAME', 'forge'),
                'password' => envGet('DB_PASSWORD', ''),
                'unix_socket' => envGet('DB_SOCKET', ''),
                'charset' => 'utf8',
                'collation' => 'utf8_bin',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([
                    PDO::MYSQL_ATTR_SSL_CA => envGet('MYSQL_ATTR_SSL_CA'),
                ]) : [],
            ],
        ]
    ]
];