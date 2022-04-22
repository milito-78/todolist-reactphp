<?php

use Core\Route\Facades\Route;
use Psr\Http\Message\RequestInterface;

Route::group("prefix",function (){

    Route::get("/test-{name}",function (RequestInterface $request)
    {
        return ["test"];
    });

});

