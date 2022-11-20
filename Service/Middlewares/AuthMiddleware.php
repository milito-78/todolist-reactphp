<?php
namespace Service\Middlewares;

use Application\Users\Queries\GetUserByToken\GetByTokenQueryInterface;
use Service\Shared\Exceptions\AuthorizationException;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Request;
use Service\Shared\Response\JsonResponse;


class AuthMiddleware
{
    private GetByTokenQueryInterface $getByTokenQuery;

    public function __construct(GetByTokenQueryInterface $getByTokenQuery)
    {
        $this->getByTokenQuery = $getByTokenQuery;
    }

    public function __invoke(Request $request,$next)
    {
        if($token = Helpers::getAuthToken($request))
        {
            return $this->getByTokenQuery
                ->Execute($token)
                ->then(function($user)use($request,$next)
                    {
                        $request->addAuth($user);
                        return $next($request);
                    },function(){
                    return JsonResponse::unAuthorized("Token is invalid");
                });
        }
        else
        {
            throw new AuthorizationException("Token is required",401);
        }
        
    }
}
