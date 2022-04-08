<?php

namespace Core\Exceptions;

use Core\Response\JsonResponse;
use React\Http\Message\ServerRequest;
use Respect\Validation\Exceptions\NestedValidationException;
use Throwable;

final class ErrorHandler
{
    public function __invoke(ServerRequest $request, callable $next): JsonResponse
    {
        global $server;

        try {
            return $next($request);
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

            return JsonResponse::internalServerError($error->getMessage());
        }

    }
}