<?php


namespace App\Domain\Outputs;

class ForgetPasswordOutput
{
    private string $token;
    private int $expiration;
    private string $message;

    public function __construct(string $token, int $expiration, string $message)
    {
        $this->token = $token;
        $this->expiration = $expiration;
        $this->message = $message;
    }

    public function output():array
    {
        return [
            "message" => $this->message,
            "data" => [
                "token"         => $this->token,
                "expiration"    => $this->expiration,
            ]
        ];
    }



}