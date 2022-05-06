<?php
namespace Core\Route\Middleware;

use Core\Response\JsonResponse;
use React\Promise\Promise;


class JsonResponseMiddleware
{
    public function __invoke($serverRequest, callable $next)
    {
        $response = $next($serverRequest);

        if ($response instanceof Promise)
        {
            return $response->then(function ($response){
                if (!$response instanceof JsonResponse)
                {
                    $response = JsonResponse::ok($response);
                }
                return $response;
            });
        }

        if (!$response instanceof JsonResponse)
        {
            $response = JsonResponse::ok($response);
        }

        return $response;
    }
}