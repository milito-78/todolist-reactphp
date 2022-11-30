<?php
namespace Application\Codes\Commands\SendCode;

interface ISendCodeCommand{
    public function Execute(string $email,string $code);
}