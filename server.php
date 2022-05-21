<?php

require "vendor/autoload.php";

const __ROOT__ = __DIR__;

$loop = include_once "bootstrap/bootstrap.php";

echo "server run on ". config("app.socket_server") . ":" . config("app.socket_port") ."\n";

$loop->run();
