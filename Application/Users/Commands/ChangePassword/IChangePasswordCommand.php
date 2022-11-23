<?php
namespace Application\Users\Commands\ChangePassword;

use React\Promise\PromiseInterface;

interface IChangePasswordCommand{
    /**
     * Execute function
     *
     * @param integer $user_id
     * @param string $current_password
     * @param string $new_password
     * @return PromiseInterface
     */
    public function Execute(int $user_id,string $current_password, string $new_password):PromiseInterface;
}