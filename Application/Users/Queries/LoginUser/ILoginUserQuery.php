<?php
namespace Application\Users\Queries\LoginUser;

use React\Promise\PromiseInterface;

interface ILoginUserQuery{
    public function Execute(string $email, string $password):PromiseInterface;
}