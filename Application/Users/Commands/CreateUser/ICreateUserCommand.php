<?php 
namespace Application\Users\Commands\CreateUser;

use React\Promise\PromiseInterface;

interface ICreateUserCommand {
    public function Execute(CreateUserModel $model): PromiseInterface;
}