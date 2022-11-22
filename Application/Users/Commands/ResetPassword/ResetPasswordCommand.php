<?php
namespace Application\Users\Commands\ResetPassword;

use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Users\Queries\CheckForgetPasswordCode\ICheckForgetPasswordCodeQuery;
use Domain\Users\User;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

class ResetPasswordCommand implements  IResetPasswordCommand{
    /**
     */
    public function __construct(
        private ICheckForgetPasswordCodeQuery $query,
        private UserRepositoryInterface $userRepository
    )
    {
    }

    public function Execute(ResetPasswordModel $model) :PromiseInterface{
        return $this->query
                    ->Execute($model->token,$model->email,$model->code)
                    ->then(function(bool $result) use($model){
                        if(!$result)
                            return reject(false);
                            
                        return $this->userRepository
                                    ->updateByEmail($model->email,[
                                        "password" => User::hashedPassword($model->password)
                                    ])->then(function ($res) {
                                        return true;
                                    });
                    });
    }
}