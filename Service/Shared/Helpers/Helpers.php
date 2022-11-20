<?php
namespace Service\Shared\Helpers;

use Common\Logger\LoggerFacade;
use Psr\Http\Message\ServerRequestInterface;
use Service\App;

class Helpers{

    public static function response($data = null , $status = 200 , $headers = null): \Service\Shared\Response\JsonResponse
    {
        return new \Service\Shared\Response\JsonResponse($status , $data , $headers);
    }

    public static function json_no_content(): \Service\Shared\Response\JsonResponse
    {
        return new \Service\Shared\Response\JsonResponse(204 ,null);
    }

    public static function head(array $arr) {
        return reset($arr);
    }

    public static function tail(array $arr): array
    {
        return array_slice($arr, 1);
    }

    public static function getAuthToken(ServerRequestInterface $request): ?string
    {
        $token = $request->getHeader("Authorization");
        return count($token) && $token[0] ? $token[0] : null;
    }

    public static function emit(string $type,string $event,$data){

        if ($type == "server"){
            $server = App::server();
            $server->emit($event,$data);
        }else{
            $server = App::socket();
            $server->emit($event,$data);
        }
    }

}

