<?php


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

if (!function_exists("env"))
{
    function env(string $key,?string $default = null)
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