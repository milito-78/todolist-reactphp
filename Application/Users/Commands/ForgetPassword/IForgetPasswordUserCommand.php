<?php
namespace Application\Users\Commands\ForgetPassword;

use React\Promise\PromiseInterface;

interface IForgetPasswordUserCommand {
    public function Execute(string $email): PromiseInterface ;
}