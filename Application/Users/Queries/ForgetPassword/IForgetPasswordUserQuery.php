<?php
namespace Application\Users\Queries\ForgetPassword;

use React\Promise\PromiseInterface;

interface IForgetPasswordUserQuery {
    public function Execute(string $email): PromiseInterface ;
}