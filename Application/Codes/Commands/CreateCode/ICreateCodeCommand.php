<?php 
namespace Application\Codes\Commands\CreateCode;

use React\Promise\PromiseInterface;

interface ICreateCodeCommand{
    public function Execute(array $payload):PromiseInterface;
}