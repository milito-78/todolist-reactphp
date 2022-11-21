<?php
namespace Service\Users\ForgetPassword;



use Respect\Validation\Validator;
use Service\Shared\Request\Request;

class ForgetPasswordRequest
{
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

        Validator::allOf($emailValidator)->assert($this->request->all());
        $this->is_validated = true;
        
        return $this;
    }

    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();

        return [
            "email"     => $this->request->email,
        ];
    }

    public function email() : string
    {
        return $this->request->email;
    }
}