<?php
namespace Infrastructure\Socket;

use Infrastructure\App;
use React\EventLoop\LoopInterface;
use React\Socket\SocketServer;

class SocketFactory{

    public static function create(LoopInterface $loop){
        return new SocketServer(
            App::config("config.socket.socket_server") . ":" . App::config("config.socket.socket_port"),
            [],
            $loop
        );
    }
}