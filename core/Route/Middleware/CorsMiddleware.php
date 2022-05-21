<?php
namespace Core\Route\Middleware;

use React\Promise\Promise;

class CorsMiddleware
{
    public function __invoke($serverRequest, callable $next)
    {
        if (preg_match('/options/i',$serverRequest->getMethod()))
        {
            return json_no_content();
        }
        $response = $next($serverRequest);
        if ($response instanceof Promise || $response instanceof \React\Promise\FulfilledPromise)
            return $response->then(function ($response){
                return $this->addCorsHeaders($response);
            });

        return $this->addCorsHeaders($response);
    }

    private function addCorsHeaders($response)
    {
        if (!$response->hasHeader("Content-type"))
            $response =  $response->withHeader("Content-type", "application/json");
        $response =  $response->withHeader("Access-Control-Allow-Origin", "*");
        $response =  $response->withHeader("Access-Control-Allow-Credentials", "true");
        $response =  $response->withHeader("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS, HEAD");
        $response =  $response->withHeader("Access-Control-Allow-Headers", "Origin, Content-Type, X-Auth-Token , Authorization");
        return $response;
    }

}