<?php
namespace Core\Response;

use React\Http\Message\ServerRequest;


class JsonRequestDecoder{
    public function __invoke(ServerRequest $request, callable $next)
    {
        if ($request->getHeaderLine("Content-type") === "application/json"){
            $request = $request->withParsedBody(
                json_decode($request->getBody()->getContents(),true)
            );
        }

        return $next($request);
    }
}