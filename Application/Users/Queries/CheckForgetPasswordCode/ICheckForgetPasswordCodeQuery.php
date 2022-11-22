<?php 
namespace Application\Users\Queries\CheckForgetPasswordCode;

use React\Promise\PromiseInterface;

interface ICheckForgetPasswordCodeQuery {
    public function Execute(string $token,string $email, string $code):PromiseInterface;
}
