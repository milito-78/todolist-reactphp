<?php 
namespace Service\Users\Login;

use Respect\Validation\Validator;
use Service\Shared\Request\Request;

class LoginRequest{

    private Request $request;
    private bool $is_validated = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate() : self
    {
        $emailValidator = Validator::key(
            'email',
            Validator::allOf(
                Validator::email(),
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('email');

        $password = Validator::key(
            'password',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('password');

        Validator::allOf($emailValidator, $password)->assert($this->request->all());
        $this->is_validated = true;

        return $this;
    }


    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();
        
        return [
            "email"     => $this->request->email,
            "password"  => $this->request->password,
        ];
    }

    public function email() : string
    {
        return $this->request->email;
    }

    public function password(): string
    {
        return $this->request->password;
    }

}