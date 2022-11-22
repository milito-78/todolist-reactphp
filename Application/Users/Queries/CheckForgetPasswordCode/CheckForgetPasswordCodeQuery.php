<?php 
namespace Application\Users\Queries\CheckForgetPasswordCode;

use Application\Codes\Queries\GetCodeByToken\GetCodeModel;
use Application\Codes\Queries\GetCodeByToken\IGetCodeByTokenQuery;
use Application\Users\Queries\GetUserByEmail\IGetUserByEmailQuery;
use Domain\Users\User;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

class CheckForgetPasswordCodeQuery implements ICheckForgetPasswordCodeQuery {
    
    public function __construct(
        private IGetCodeByTokenQuery $tokenQuery,
        private IGetUserByEmailQuery $userQuery
    )
    {
    }

    public function Execute(string $token,string $email, string $code) :PromiseInterface {
        return $this->userQuery
                    ->Execute($email)
                    ->then(function(User $user) use ($token,$code){
                        return $this->tokenQuery
                                    ->Execute($token)
                                    ->then(function(GetCodeModel $codeModel) use ($code){
                                        if($codeModel->code == $code)
                                            return true;
                                        return reject(false);
                                    });
                    });
    }
}
