<?php

namespace Core\Exceptions;

use Core\Response\JsonResponse;
use React\Http\Message\ServerRequest;
use React\Promise\Promise;
use Respect\Validation\Exceptions\NestedValidationException;
use RuntimeException;
use Throwable;

final class ErrorHandler
{
    public function __invoke(ServerRequest $request, callable $next)
    {
        global $server;

        try {
            $response = $next($request);
            
            if ($response instanceof Promise)
            {
                return $response->then(function ($response){
                    $response = $this->checkErrorResponse($response);
                    return $response;
                },function($exception){
                    $response = $this->checkErrorResponse($exception);
                    return $response;
                });
            }

            return $response;
        }
        catch (NestedValidationException $exception)
        {
            return JsonResponse::validationError(array_values($exception->getMessages()));
        }
        catch (ValidationException $exception)
        {
            return JsonResponse::validationError($exception->getMessage());
        }
        catch (MethodNotAllowedException $exception){
            $server->emit("error" , [$exception]);

            return JsonResponse::methodNotAllowed($exception->getMessage());
        }
        catch (NotFoundException $exception){
            $server->emit("error" , [$exception]);

            return JsonResponse::notFound($exception->getMessage());
        }
        catch (AuthorizationException $exception){
            $server->emit("error" , [$exception]);

            return JsonResponse::unAuthorized($exception->getMessage());
        }
        catch (ForbiddenException $exception){
            $server->emit("error" , [$exception]);

            return JsonResponse::Aborted($exception->getMessage());
        }
        catch (Throwable $error){
            $server->emit("error" , [$error]);
            var_dump($error->getMessage());

            return JsonResponse::internalServerError($error->getMessage());
        }
    }

    private function checkErrorResponse($response){
        global $server;

        if ($response instanceof NestedValidationException)
        {
            return JsonResponse::validationError(array_values($response->getMessages()));
        }
        if ($response instanceof ValidationException)
        {
            return JsonResponse::validationError($response->getMessage());
        }
        if ($response instanceof MethodNotAllowedException ){
            $server->emit("error" , [$response]);

            return JsonResponse::methodNotAllowed($response->getMessage());
        }
        
        if ($response instanceof NotFoundException ){
            $server->emit("error" , [$response]);

            return JsonResponse::notFound($response->getMessage());
        }
        
        if ($response instanceof AuthorizationException ){
            $server->emit("error" , [$response]);

            return JsonResponse::unAuthorized($response->getMessage());
        }
        
        if ($response instanceof ForbiddenException ){
            $server->emit("error" , [$response]);

            return JsonResponse::Aborted($response->getMessage());
        }
        
        if ($response instanceof Throwable){
            $server->emit("error" , []);

            return JsonResponse::internalServerError($response->getMessage());
        }

        return $response;
    }
}