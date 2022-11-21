<?php 
namespace Service\Users\Register;


use Respect\Validation\Validator;
use Service\Shared\Request\Request;

class RegisterRequest{

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
    
        $fullnameValidator = Validator::key(
            'full_name',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('full_name');

        $password = Validator::key(
            'password',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('password');

        $passwordConfirmation = Validator::
        keyValue('password_confirmation', 'equals', 'password')
        ->setName("password confirmation");

        Validator::allOf($emailValidator,$fullnameValidator, $password,$passwordConfirmation)
            ->assert($this->request->all());
        $this->is_validated = true;

        return $this;
    }


    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();
        
        return [
            "full_name" => $this->request->full_name,
            "email"     => $this->request->email,
            "password"  => $this->request->password,
        ];
    }

    public function email() : string
    {
        return $this->request->email;
    }

    public function fullName() : string
    {
        return $this->request->full_name;
    }

    public function password(): string
    {
        return $this->request->password;
    }

}