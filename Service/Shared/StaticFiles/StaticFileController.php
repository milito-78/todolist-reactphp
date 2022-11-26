<?php


namespace Service\Shared\StaticFiles;


use Infrastructure\Files\Entities\File;
use Infrastructure\Files\Exceptions\FileNotFound;
use Infrastructure\Files\Storage;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use React\Promise\PromiseInterface;

class StaticFileController extends Controller
{

    public function __invoke(ServerRequestInterface $request,$file): PromiseInterface
    {
        return Storage::get($request->getUri()->getPath())
            ->then(
                function (File $file) {
                    return Helpers::response($file->contents,200, ['Content-Type' => $file->mimeType]);
                }
            )->otherwise(
                function (FileNotFound $exception) {
                    return JsonResponse::notFound("Route not found!");
                }
            )->otherwise(
                function (\Exception $exception) {
                    return Helpers::response($exception->getMessage(),500);
                }
            );
    }
}