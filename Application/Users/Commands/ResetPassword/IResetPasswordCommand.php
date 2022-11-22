<?php
namespace Application\Users\Commands\ResetPassword;

use React\Promise\PromiseInterface;

interface IResetPasswordCommand{
    public function Execute(ResetPasswordModel $model) :PromiseInterface;
}