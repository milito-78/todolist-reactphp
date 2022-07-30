<?php


namespace App\UseCase;


use App\Core\Repositories\UserRepositoryInterface;
use App\Domain\Inputs\ForgetPasswordInput;
use App\Domain\Outputs\ForgetPasswordOutput;
use Core\Cache\CacheFacade as Cache;

class ForgetPasswordUseCase implements ForgetPasswordUseCaseInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(ForgetPasswordInput $input)
    {
        $input->validate();

        return $this->userRepository
            ->findByEmail($input->email())
            ->then(function($user) use ($input){
                $token = password_hash($input->email(), PASSWORD_BCRYPT);
                $payload = ["email" => $input->email(),"type" => "forget"];
                $key = base64_encode(json_encode($payload));

                return Cache::get($key)
                    ->then(function ($value) use($key,$token,$input){
                        if ($value)
                        {
                            list($t,$code,$exp) = explode("-",$value);
                            $seconds_diff = $exp - time();

                            $output = new ForgetPasswordOutput($t,$seconds_diff,"Code send you before");

                        }else{
                            $now = time();
                            $expire = $now + (2 * 60);
                            $code = rand(10000,99999);
                            Cache::set($key,$token. "-" . $code."-". $expire ,(2 * 60));
                            emit("server","send_verify_code_email",["email" => $input->email(),"code" => (string)$code]);

                            $output = new ForgetPasswordOutput($token,(2 * 60),"Code sent to your email");
                        }
                        return response($output->output());
                    });
            });
    }
}