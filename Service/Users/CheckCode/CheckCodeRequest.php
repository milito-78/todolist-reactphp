<?php
namespace Service\Users\CheckCode;

use Respect\Validation\Validator;
use Service\Shared\Request\Request;

class CheckCodeRequest
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
        
        return $this;
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