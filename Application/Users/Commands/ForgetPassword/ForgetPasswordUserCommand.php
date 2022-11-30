<?php
namespace Application\Users\Commands\ForgetPassword;

use Application\Codes\Commands\CreateCode\ICreateCodeCommand;
use Application\Codes\Commands\SaveCode\SaveCodeModel;
use Application\Users\Queries\GetUserByEmail\IGetUserByEmailQuery;
use Domain\Users\User;
use React\Promise\PromiseInterface;
use Service\Shared\Helpers\Helpers;

class ForgetPasswordUserCommand  implements IForgetPasswordUserCommand {
    /**
     */
    public function __construct(
        private IGetUserByEmailQuery $query,
        private ICreateCodeCommand $command
    ) 
    {
    }

    public function Execute(string $email): PromiseInterface {
        return $this->query
                    ->Execute($email)
                    ->then(function(User $user){
                        return $this->command->Execute([
                            "email" => $user->email,
                            "code_type" => "forget-password"
                        ])->then(function(SaveCodeModel $send) use ($user){
                            $this->sendCode($user->email,$send->code);
                            return $send;
                        });
                    });
    }

    private function sendCode(string $email,string $code){
        Helpers::emit("server","send_verify_code_email",["email" => $email,"code" => $code]);
    }
}