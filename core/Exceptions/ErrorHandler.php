<?php

namespace Core\Exceptions;

use Core\Response\JsonResponse;
use React\Http\Message\ServerRequest;
use React\Promise\FulfilledPromise;
use React\Promise\Promise;
use Respect\Validation\Exceptions\NestedValidationException;
use Throwable;

final class ErrorHandler
{
    public function __invoke(ServerRequest $request, callable $next)
    {
        
        try {
            $response = $next($request);
            
            if ($response instanceof Promise || $response instanceof FulfilledPromise)
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
            return JsonResponse::validationError($this->parseErrors($exception->getMessages()));
        }
        catch (ValidationException $exception)
        {
            return JsonResponse::validationError([$exception->getMessage()]);
        }
        catch (MethodNotAllowedException $exception){
            emit("error" , [$exception]);

            return JsonResponse::methodNotAllowed($exception->getMessage());
        }
        catch (NotFoundException $exception){
            emit("error" , [$exception]);

            return JsonResponse::notFound($exception->getMessage());
        }
        catch (AuthorizationException $exception){
            emit("error" , [$exception]);

            return JsonResponse::unAuthorized($exception->getMessage());
        }
        catch (ForbiddenException $exception){
            emit("error" , [$exception]);

            return JsonResponse::Aborted($exception->getMessage());
        }
        catch (Throwable $error){
            emit("error" , [$error]);

            return JsonResponse::internalServerError($error->getMessage());
        }
    }

    private function checkErrorResponse($response)
    {
        if ($response instanceof NestedValidationException)
        {
            return JsonResponse::validationError($this->parseErrors($response->getMessages()));
        }
        elseif ($response instanceof ValidationException)
        {
            return JsonResponse::validationError([$response->getMessage()]);
        }
        elseif ($response instanceof MethodNotAllowedException ){
            emit("error" , [$response]);
            return JsonResponse::methodNotAllowed($response->getMessage());
        }
        elseif ($response instanceof NotFoundException ){
            emit("error" , [$response]);
            return JsonResponse::notFound($response->getMessage());
        }
        elseif ($response instanceof AuthorizationException ){
            emit("error" , [$response]);
            return JsonResponse::unAuthorized($response->getMessage());
        }
        elseif ($response instanceof ForbiddenException ){
            emit("error" , [$response]);
            return JsonResponse::Aborted($response->getMessage());
        }
        elseif ($response instanceof Throwable){
            emit("error" , [$response]);

            return JsonResponse::internalServerError($response->getMessage());
        }

        return $response;
    }

    private function parseErrors(array $errors){
        $temp = [];

        foreach($errors as $key => $error_message){
            if(is_array($error_message))
                foreach($error_message as $field => $message)
                {
                    $temp[] = $message;
                }            
            else
                $temp[] = $error_message;
        }
        return $temp;
    }
}