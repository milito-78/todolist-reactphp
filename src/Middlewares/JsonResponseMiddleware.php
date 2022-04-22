<?php
namespace App\Middlewares;

use Core\Response\JsonResponse;


class JsonResponseMiddleware
{
    public function __invoke($serverRequest, callable $next):JsonResponse
    {
        $response = $next($serverRequest);

        if (!$response instanceof JsonResponse)
        {
            $response = JsonResponse::ok($response);
        }

        return $response;
    }
}