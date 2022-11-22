<?php 
namespace Application\Users\Commands\ResetPassword;


class ResetPasswordModel{
    public function __construct(
        public string $email,
        public string $token,
        public string $code,
        public string $password
    )
    {
    }
}