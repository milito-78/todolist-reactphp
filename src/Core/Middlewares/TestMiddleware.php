<?php
namespace App\Core\Middlewares;

use Psr\Http\Message\ServerRequestInterface;

class TestMiddleware{

    public function __invoke(ServerRequestInterface $request,$next,$guard = "admin")
    {
        var_dump("test middleware",$guard );

        return $next($request);
    }
}
