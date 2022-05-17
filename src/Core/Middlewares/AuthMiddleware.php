<?php
namespace App\Core\Middlewares;

use App\UseCase\AuthenticateUseCaseInterface;
use Core\Exceptions\AuthorizationException;
use Core\Request\Request;
use Core\Response\JsonResponse;

class AuthMiddleware
{
    private AuthenticateUseCaseInterface $authenticateService;

    public function __construct(AuthenticateUseCaseInterface $authenticateService)
    {
        $this->authenticateService = $authenticateService;
    }

    public function __invoke(Request $request,$next)
    {
        if($token = getAuthToken($request))
        {
            return $this->authenticateService
                ->authenticate($token)
                ->then(function($user)use($request,$next)
                    {
                        $request->addAuth($user);
                        return $next($request);
                    })
                ->otherwise(function(AuthorizationException $exception){
                    return JsonResponse::unAuthorized($exception->getMessage()); 
                });
        }
        else
        {
            throw new AuthorizationException("Token is required",401);
        }
        
    }
}
