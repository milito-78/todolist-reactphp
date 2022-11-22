<?php


use Service\Shared\Route\RouteFacade as Route;
use Psr\Http\Message\RequestInterface;
use Service\Options\Splash\SplashController;
use Service\Tasks\Controller\TaskIndexController;
use Service\Tasks\Controller\TaskShowController;
use Service\Tasks\Controller\TaskStoreController;
use Service\Users\CheckCode\CheckCodeController;
use Service\Users\ForgetPassword\ForgetPasswordController;
use Service\Users\Login\LoginController;
use Service\Users\Register\RegisterController;
use Service\Users\ResetPassword\ResetPasswordController;

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
//        Route::get("profile"        , ProfileController::class);
//        Route::post("logout"        , LogoutController::class);
//        Route::patch("change-password" , ChangePasswordController::class);

        Route::group("tasks",function(){
            Route::get(""           , TaskIndexController::class);
            Route::post(""          , TaskStoreController::class);
            Route::get("/{task}"    , TaskShowController::class);
//            Route::patch("/{task}"  , TaskUpdateController::class);
//            Route::delete("/{task}" , TaskDeleteController::class);
        });
    },["auth"]);
});

//Route::post("uploader" , ImageUploadController::class);
