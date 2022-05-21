<?php


namespace Core\Filesystem\StaticFiles;


use Core\Exceptions\NotFoundException;
use Core\Request\Controller;
use Core\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use React\Promise\PromiseInterface;

class StaticFileController extends Controller
{
    private Webroot $webroot;

    public function __construct(Webroot $webroot)
    {
        $this->webroot = $webroot;
    }

    public function __invoke(ServerRequestInterface $request,$file): PromiseInterface
    {
        return $this->webroot->file($request->getUri()->getPath())
            ->then(
                function (File $file) {
                    return response($file->contents,200, ['Content-Type' => $file->mimeType]);
                }
            )
            ->otherwise(
                function (\Narrowspark\MimeType\Exception\FileNotFoundException|FileNotFound $exception) {
                    return JsonResponse::notFound("Route not found!");
                }
            )->otherwise(
                function (\Exception $exception) {
                    return response($exception->getMessage(),500);
                }
            );
    }
}