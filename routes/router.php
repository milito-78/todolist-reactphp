<?php

use App\Core\Controller\LoginController;
use App\Core\Controller\ProfileController;
use App\Core\Controller\RegisterController;
use App\Core\Controller\SplashController;
use App\Core\Controller\LogoutController;
use App\Core\Controller\Task\TaskDeleteController;
use App\Core\Controller\Task\TaskIndexController;
use App\Core\Controller\Task\TaskShowController;
use App\Core\Controller\Task\TaskStoreController;
use App\Core\Controller\Task\TaskUpdateController;
use Core\Route\RouteFacade as Route;
use Psr\Http\Message\RequestInterface;

Route::get('/splash'            , SplashController::class);

Route::group("user",function () {

    Route::post("register"      , RegisterController::class);
    Route::post("login"         , LoginController::class);
    
    Route::group('/',function () {
        Route::get("profile"        , ProfileController::class);
        Route::patch("logout"       , LogoutController::class);

        Route::group("tasks",function(){
            Route::get(""           , TaskIndexController::class);
            Route::post(""          , [TaskStoreController::class,"store"]);
            Route::get("/{task}"    , [TaskShowController::class,"show"]);
            Route::patch("/{task}"  , [TaskUpdateController::class,"update"]);
            Route::delete("/{task}" , [TaskDeleteController::class,"destroy"]);
        });
    },["auth"]);

});