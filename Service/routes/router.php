<?php

use App\Core\Controller\Auth\ForgetPassword\CheckCodeController;
use App\Core\Controller\Auth\ForgetPassword\ForgetPasswordController;
use App\Core\Controller\Auth\ForgetPassword\ResetPasswordController;
use App\Core\Controller\ImageUploadController;
use App\Core\Controller\Auth\LoginController;
use App\Core\Controller\Profile\ChangePasswordController;
use App\Core\Controller\Profile\ProfileController;
use App\Core\Controller\Auth\RegisterController;
use App\Core\Controller\SplashController;
use App\Core\Controller\Auth\LogoutController;
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

    Route::group('forgot-password',function (){
        Route::post("/send-code"         , ForgetPasswordController::class);
        Route::get("/check-code"         , CheckCodeController::class);
        Route::post("/reset-password"    , ResetPasswordController::class);
    });

    Route::group('/',function () {
        Route::get("profile"        , ProfileController::class);
        Route::post("logout"        , LogoutController::class);
        Route::patch("change-password" , ChangePasswordController::class);

        Route::group("tasks",function(){
            Route::get(""           , TaskIndexController::class);
            Route::post(""          , TaskStoreController::class);
            Route::get("/{task}"    , TaskShowController::class);
            Route::patch("/{task}"  , TaskUpdateController::class);
            Route::delete("/{task}" , TaskDeleteController::class);
        });
    },["auth"]);
});

Route::post("uploader" , ImageUploadController::class);
