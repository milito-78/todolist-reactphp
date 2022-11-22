<?php
namespace Service\Users\ResetPassword;


use Respect\Validation\Validator;
use Service\Shared\Request\Request;

class ResetPasswordRequest
{
    private Request $request;
    private bool $is_validated = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate(): self
    {
        $emailValidator = Validator::key(
            'email',
            Validator::allOf(
                Validator::email(),
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('email');

        $passwordValidator = Validator::key(
            'password',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('password');

        $codeValidator = Validator::key(
            'code',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('code');


        $tokenValidator = Validator::key(
            'token',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('token');


        $passwordConfirmation = Validator::
        keyValue('password_confirmation', 'equals', 'password')
            ->setName("password confirmation");

        Validator::allOf($emailValidator,$codeValidator,$tokenValidator,$passwordValidator,$passwordConfirmation)
            ->assert($this->request->all());
        $this->is_validated = true;

        return $this;
    }

    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();

        return [
            "email"    => $this->request->email,
            "password" => $this->request->password,
            "token"    => $this->request->token,
        ];
    }

    public function email() : string
    {
        return $this->request->email;
    }

    public function token() : string
    {
        return $this->request->token;
    }

    public function password():string 
    {
        return $this->request->password;
    }

    public function code() : string
    {
        return $this->request->code;
    }
}