<?php 
namespace Application\Users\Queries\CheckForgetPassswordCode;

use React\Promise\PromiseInterface;

interface ICheckForgetPassswordCodeQuery {
    public function Execute(string $token,string $email, string $code):PromiseInterface;
}
