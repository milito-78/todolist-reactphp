<?php 
namespace Application\Users\Queries\CheckForgetPassswordCode;

use React\Promise\PromiseInterface;

class CheckForgetPassswordCodeQuery implements ICheckForgetPassswordCodeQuery {
    
    public function __construct(){

    }

    public function Execute(string $token,string $email, string $code):PromiseInterface{

    }
}
