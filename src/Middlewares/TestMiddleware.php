<?php
namespace App\Middlewares;

use Core\Route\Middleware\Middleware;
use Psr\Http\Message\ServerRequestInterface;

class TestMiddleware extends Middleware
{
    public function handle(ServerRequestInterface $request, callable $next)
    {
        return $next($request);
    }
}