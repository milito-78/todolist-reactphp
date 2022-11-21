<?php 
namespace Application\Codes\Commands\CreateCode;

use Application\Codes\Commands\SaveCode\ISaveCodeCommand;
use Application\Codes\Queries\GetCodeByToken\Exceptions\CodeExpiredException;
use Application\Codes\Queries\GetCodeByToken\GetCodeModel;
use Application\Codes\Queries\GetCodeByToken\IGetCodeByTokenQuery;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

class CreateCodeCommand implements ICreateCodeCommand{
     /**
     */
    public function __construct(
        private IGetCodeByTokenQuery $query,
        private ISaveCodeCommand $command
    ) {
    }

    public function Execute(array $payload) :PromiseInterface{
        $token  = $this->generateToken($payload);
        return  $this->query->Execute($token)
            ->then(function(GetCodeModel $value) use ($token){
                return reject(new SendBeforeModel($value->code,$token,$value->expire_secs));
            },function (CodeExpiredException $exception) use ($token) {
                return $this->command->Execute($token);
            });
    }

    private function generateToken(array $payload) : string{
        return base64_encode(json_encode($payload));
    }

}