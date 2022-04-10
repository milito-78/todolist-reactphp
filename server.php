<?php

require "vendor/autoload.php";

$loop = include_once "bootstrap/bootstrap.php";

echo "server run on ". config("app.socket_server") . ":" . config("app.socket_port") ."\n";

$loop->run();
