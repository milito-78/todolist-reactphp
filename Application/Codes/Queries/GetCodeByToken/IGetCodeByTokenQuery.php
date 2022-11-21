<?php 
namespace Application\Codes\Queries\GetCodeByToken;

use React\Promise\PromiseInterface;

interface IGetCodeByTokenQuery {
    public function Execute(string $token):PromiseInterface;
}