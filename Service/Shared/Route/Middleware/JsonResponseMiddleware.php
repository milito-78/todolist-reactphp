<?php
namespace Service\Shared\Route\Middleware;

use Service\Shared\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use React\Promise\Promise;


class JsonResponseMiddleware
{
    public function __invoke($serverRequest, callable $next)
    {
        $response = $next($serverRequest);
        if ($response instanceof Promise || $response instanceof \React\Promise\FulfilledPromise)
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