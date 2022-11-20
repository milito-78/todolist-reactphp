<?php


$loop = include_once "bootstrap/bootstrap.php";

echo "server run on ". \Service\App::config("config.socket_server") . ":" . \Service\App::config("config.socket_port") ."\n";

$loop->run();
