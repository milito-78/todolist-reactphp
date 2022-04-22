<?php


namespace App\Middlewares;

use Core\Response\JsonResponse;

class CorsMiddleware
{
    public function __invoke($serverRequest, callable $next):JsonResponse
    {
        if (preg_match('/options/i',$serverRequest->getMethod()))
        {
            return json_no_content();
        }

        $response = $next($serverRequest);

        $response =  $response->withHeader("Content-type", "application/json");
        $response =  $response->withHeader("Access-Control-Allow-Origin", "*");
        $response =  $response->withHeader("Access-Control-Allow-Credentials", "true");
        $response =  $response->withHeader("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS, HEAD");
        $response =  $response->withHeader("Access-Control-Allow-Headers", "Origin, Content-Type, X-Auth-Token , Authorization");

        return $response;
    }

}