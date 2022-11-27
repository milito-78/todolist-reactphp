<?php


namespace Service\Shared\StaticFiles;

use Application\Files\Queries\ShowFile\IShowFileQuery;
use Infrastructure\Files\Entities\File;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use React\Promise\PromiseInterface;

class StaticFileController extends Controller
{
    public function __construct(private IShowFileQuery $query)
    {
    }

    public function __invoke(ServerRequestInterface $request,$file): PromiseInterface
    {
        return $this->query->Execute($request->getUri()->getPath())
            ->then(
                function (?File $file) {
                    if($file)
                        return Helpers::response($file->contents,200, ['Content-Type' => $file->mimeType]);
                    return JsonResponse::notFound("Route not found!");
                }
            )->otherwise(
                function (\Exception $exception) {
                    return Helpers::response($exception->getMessage(),500);
                }
            );
    }
}