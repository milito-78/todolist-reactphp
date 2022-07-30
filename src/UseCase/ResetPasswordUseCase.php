<?php 

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Inputs\ResetPasswordInput;
use App\Domain\Outputs\ResetPasswordOutput;
use Core\Cache\CacheFacade as Cache;
use Core\Exceptions\ValidationException;

class ResetPasswordUseCase implements ResetPasswordUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function handle(ResetPasswordInput $input){
        $input->validate();

        return $this->userRepository
            ->findByEmail($input->email())
            ->then(function($user) use ($input){

                if (!password_verify($input->email(), $input->token())) {
                    throw new ValidationException("token is invalid");
                }

                $payload    = ["email" => $input->email(),"type" => "forget"];
                $key        = base64_encode(json_encode($payload));

                return Cache::get($key)
                    ->then(function ($value) use($key,$input,$user){
                        if ($value)
                        {
                            list($t,$code,$exp) = explode("-",$value);

                            if ($code != $input->code()){
                                throw new ValidationException("code is invalid");
                            }else {
                                return $this->userRepository->update($user["id"],[
                                    "password" => $input->passwordHashed()
                                ])->then(function ($res) {
                                    $output = new ResetPasswordOutput("Password reset successfully");
                                    return response($output->output());
                                });

                            }
                        }else{
                            throw new ValidationException("code is invalid");
                        }
                    });
            });

    }
}