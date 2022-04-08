<?php


namespace Core\Request;


use Psr\Http\Message\ServerRequestInterface;

class Request implements ServerRequestInterface
{
    use ServerRequestImplementsTrait;

    public ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request) {
        $this->request = $request;
    }
}