<?php 
namespace Persistence\Codes;

use Application\Interfaces\Persistence\ICodeRepository;
use Infrastructure\Cache\Facade\Cache;
use React\Promise\PromiseInterface;

use function React\Promise\resolve;

class CodeRepository implements ICodeRepository{
    
	/**
	 * @param string $key
	 * @param string $code
	 * @return \React\Promise\PromiseInterface
	 */
	public function saveCode(string $key, string $code,int $expire = null):PromiseInterface {
        Cache::set( $key, $code, $expire);
        return resolve(1);
	}
	
	/**
	 *
	 * @param string $key
	 * @return \React\Promise\PromiseInterface
	 */
	public function getCode(string $key): PromiseInterface {
        return Cache::get($key);
	}
	
	/**
	 *
	 * @param string $key
	 * @return \React\Promise\PromiseInterface
	 */
	public function deleteCode(string $key): PromiseInterface {
        Cache::set( $key,null, -1000);
        return resolve(1);
	}
}