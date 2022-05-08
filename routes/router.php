<?php

use App\Core\Controller\SplashController;
use Core\Route\Facades\Route;
use Psr\Http\Message\RequestInterface;

Route::get('/splash', SplashController::class);

