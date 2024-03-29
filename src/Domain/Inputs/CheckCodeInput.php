<?php


namespace App\Domain\Inputs;


use Core\Request\Request;
use Respect\Validation\Validator;

class CheckCodeInput
{
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

        Validator::allOf($emailValidator,$codeValidator,$tokenValidator)->assert($this->request->getQueryParams());
        $this->is_validated = true;
    }

    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();

        return [
            "email"    => $this->request->email,
            "code"     => $this->request->code,
            "token"    => $this->request->token,
        ];
    }

    public function code() : string
    {
        return $this->request->code;
    }

    public function email() : string
    {
        return $this->request->email;
    }

    public function token() : string
    {
        return $this->request->token;
    }
}