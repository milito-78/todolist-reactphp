<?php 
namespace Application\Codes\Commands\SaveCode;

use Application\Interfaces\Persistence\ICodeRepository;
use React\Promise\PromiseInterface;

class SaveCodeCommand implements ISaveCodeCommand{
    public function __construct(private ICodeRepository $codeRepository)
    {
    }

    public function Execute(array|string $payload,?string $code = null):PromiseInterface{
        if(is_string($payload)){
            $token = $payload;
        }else{
            $token = $this->generateToken($payload);
        }

        $expire_time_stamp  = $this->expiredAfter();
        $expire             = $this->expireSecs();

        return $this->codeRepository
            ->saveCode($token,$this->saveData($code,$expire_time_stamp),$expire)
            ->then(function($_no_matter) use ($token,$code,$expire){
                return new SaveCodeModel($code,$token,$expire);
            });
    }

    private function generateRandomCode(): string {
        return (string)rand(10000,99999);
    }

    private function expiredAfter():int{
       return time() + $this->expireSecs();
    }

    private function generateToken(array $payload) : string{
        return base64_encode(json_encode($payload));
    }

    private function saveData(string $code ,int $exp) : string{
        return $code . "-" . $exp;
    }

    private function expireSecs() : int{
        return (2 * 60);
    }
}