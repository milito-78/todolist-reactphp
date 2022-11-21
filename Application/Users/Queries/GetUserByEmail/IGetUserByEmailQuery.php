<?php 
namespace Application\Users\Queries\GetUserByEmail;

use React\Promise\PromiseInterface;

interface IGetUserByEmailQuery {
    public function Execute(string $email) : PromiseInterface;
}