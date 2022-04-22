<?php

use Core\Route\Route;
use Psr\Http\Message\RequestInterface;

Route::GROUP("prefix",function (){
    Route::GET("/test-{name}",function (RequestInterface $request)
    {
        return response(["sss"]);
    },["test"]);

    Route::POST("/test-{name}",function (RequestInterface $request)
    {
        return response(["sss"]);
    },["test"]);
});

