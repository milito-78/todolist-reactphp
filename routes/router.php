<?php

use App\Core\Controller\LoginController;
use App\Core\Controller\ProfileController;
use App\Core\Controller\RegisterController;
use App\Core\Controller\SplashController;
use App\Core\Controller\LogoutController;
use Core\Route\Facades\Route;
use Psr\Http\Message\RequestInterface;

Route::get('/splash', [SplashController::class, "index"]);

Route::group("user",function () {

    Route::post("register"  , [RegisterController::class, "store"]);
    Route::post("login"     , [LoginController::class, "store"]);
    //Add auth middleware
    Route::get("profile"    , [ProfileController::class,"show"]);
    Route::patch("logout"   , [LogoutController::class,"patch"]);
});