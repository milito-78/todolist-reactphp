<?php 

namespace App\Domain\Inputs;

use Core\Request\Request;
use Respect\Validation\Validator;

class LoginInput{

    private Request $request;
    private bool $is_validated = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
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

    public function fullName() : string
    {
        return $this->request->full_name;
    }

    public function password(): string
    {
        return $this->request->password;
    }

}