<?php 
namespace Application\Users\Commands\RegisterUser;

use React\Promise\PromiseInterface;

interface IRegisterUserCommand {
    public function Execute(RegisterUserModel $model): PromiseInterface;
}