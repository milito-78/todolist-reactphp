<?php

use League\Container\Container;
use Psr\Http\Message\ServerRequestInterface;

if (!function_exists("response"))
{
    function response($data = null , $status = 200 , $headers = null): \Core\Response\JsonResponse
    {
        return new \Core\Response\JsonResponse($status , $data , $headers);
    }
}

if (!function_exists("json_no_content"))
{
    function json_no_content(): \Core\Response\JsonResponse
    {
        return new \Core\Response\JsonResponse(204 ,null);
    }
}

if (!function_exists("abort")){
    function abort($status = 500 , $message = "Server Error")
    {
        $error = new \Core\Exceptions\Model\ErrorModel("Server Error",$message);
        switch ($status)
        {
            case 404 :
                $error->title =  "Not Found";
                break;
            case 401 :
                $error->title =  "Unauthorized";
                break;
            case 405 :
                $error->title =  "Method Not Allowed";
                break;
            case 403 :
                $error->title =  "Access Denied";
                break;
            case 422 :
                $error->title =  "Validation Failed";
                break;
            case 500 :
            default :
                $error->title =  "Server Error";
                break;
        }

        return new \Core\Response\JsonResponse( $status , $error->toArray());
    }
}

if (!function_exists("envGet"))
{
    function envGet(string $key,$default = null)
    {
        return $_ENV[$key]??$default;
    }
}

if (!function_exists("config"))
{
    function config(string $key, $default = null)
    {
        global $config;
        return $config->get($key,$default);
    }
}

if (!function_exists("logger"))
{
    function logger() :  Monolog\Logger
    {
        global $container;
        return $container->get((string) "logger");
    }
}

if(!function_exists("head")){
    function head(array $arr) {
        return reset($arr);
    }
}

if(!function_exists("tail")){
    function tail(array $arr) {
        return array_slice($arr, 1);
    }
}


if(!function_exists("getAuthToken"))
{
    function getAuthToken(ServerRequestInterface $request)
    {
        $token = $request->getHeader("Authorization");
        return count($token) && $token[0] ? $token[0] : null;
    }
}

if (!function_exists("filesystem")){
    function filesystem(){
        global $container;
        return $container->get((string) "filesystem");
    }
}

if (!function_exists("emit")){
    function emit(string $type,string $event,$data){
        if ($type == "server"){
            global $server;
            $server->emit($event,$data);
        }else{
            global $socket;
            $socket->emit($event,$data);
        }
    }
}

if (!function_exists("loop")){
    function loop(){
        global $loop;
        return $loop;
    }
}