<?php
namespace Service\Users\ChangePassword;

use Respect\Validation\Validator;
use Service\Shared\Request\Request;

class ChangePasswordRequest
{
    private Request $request;
    private bool $is_validated = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate():self
    {
        $currentPassword = Validator::key(
            'current_password',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('current_password');

        $passwordValidator = Validator::key(
            'password',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('password');

        $passwordConfirmation = Validator::
        keyValue('password_confirmation', 'equals', 'password')
            ->setName("password confirmation");

        Validator::allOf($currentPassword,$passwordValidator,$passwordConfirmation)
            ->assert($this->request->all());
        $this->is_validated = true;

        return $this;
    }

    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();

        return [
            "current_password"  => $this->request->current_password,
            "password"          => $this->passwordHashed(),
            "password_string"   => $this->request->password,
        ];
    }

    public function currentPassword() : string
    {
        return $this->request->current_password;
    }

    public function passwordHashed(): string
    {
        return password_hash($this->request->password, PASSWORD_BCRYPT);
    }

    public function password(): string
    {
        return $this->request->password;
    }

    public function request(): Request
    {
        return $this->request;
    }
}