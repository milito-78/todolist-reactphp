<?php 

namespace App\UseCase;

use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Inputs\CheckCodeInput;
use App\Domain\Outputs\CheckCodeOutput;
use Core\Cache\CacheFacade as Cache;

class CheckCodeUseCase implements CheckCodeUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(CheckCodeInput $input)
    {
        $input->validate();

        return $this->userRepository
            ->findByEmail($input->email())
            ->then(function($user) use ($input){

                if (!password_verify($input->email(), $input->token())) {
                    return response((new CheckCodeOutput(false,"Token is invalid"))->output());
                }

                $payload    = ["email" => $input->email(),"type" => "forget"];
                $key        = base64_encode(json_encode($payload));

                return Cache::get($key)
                    ->then(function ($value) use($key,$input){
                        if ($value)
                        {
                            list($t,$code,$exp) = explode("-",$value);

                            if ($code != $input->code()){
                                $output = new CheckCodeOutput(false,"Code is invalid");
                            }else
                                $output = new CheckCodeOutput(true,"Code is valid");

                        }else{
                            $output = new CheckCodeOutput(false,"Code is invalid");
                        }

                        return response($output->output());
                    });
            });
    }
}