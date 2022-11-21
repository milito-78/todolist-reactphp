<?php 
namespace Application\Codes\Commands\SaveCode;

use React\Promise\PromiseInterface;

interface ISaveCodeCommand{
    public function Execute(array|string $payload,?string $code = null):PromiseInterface;
}