<?php 

namespace App\Domain\Inputs;

use Core\Request\Request;
use Respect\Validation\Validator;

class RegisterInput{

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

        Validator::allOf($emailValidator,$fullnameValidator, $password)->assert($this->request->all());
        $this->is_validated = true;
    }


    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();
        
        return [
            "full_name" => $this->request->full_name,
            "email"     => $this->request->email,
            "password"  => password_hash($this->request->password, PASSWORD_BCRYPT),
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

    public function passwordHashed(): string
    {
        return password_hash($this->request->password, PASSWORD_BCRYPT);
    }

}