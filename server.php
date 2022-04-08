<?php

require "vendor/autoload.php";

$loop = include_once "bootstrap/bootstrap.php";

echo "server run on 127.0.0.1:3000\n";

$loop->run();

