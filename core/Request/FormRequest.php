<?php

namespace Core\Request;

use Psr\Http\Message\ServerRequestInterface;


abstract class FormRequest extends Request implements ValidationRequest, ServerRequestInterface
{

    public ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request) {
        $this->request = $request;
    }
 }
