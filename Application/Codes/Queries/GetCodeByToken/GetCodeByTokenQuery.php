<?php 
namespace Application\Codes\Queries\GetCodeByToken;

use Application\Codes\Queries\GetCodeByToken\Exceptions\CodeExpiredException;
use Application\Interfaces\Persistence\ICodeRepository;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

class GetCodeByTokenQuery implements IGetCodeByTokenQuery{
    /**
     */
    public function __construct(private ICodeRepository $codeRepository) {
    }

	/**
	 * @param string $token
	 * @return \React\Promise\PromiseInterface
	 */
	public function Execute(string $token): PromiseInterface {
        return $this->codeRepository
                    ->getCode($token)
                    ->then(function ($value){
                        if ($value){
                            return $this->returnModel($value);
                        }else{
                            return reject(new CodeExpiredException());
                        }
                    });
	}

    private function returnModel($value) :GetCodeModel{
        list($code,$exp) = explode("-",$value);
        $seconds_diff = $exp - time();
        return new GetCodeModel($code,$seconds_diff,(int)$exp);
    }
}