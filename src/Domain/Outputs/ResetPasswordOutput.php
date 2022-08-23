<?php


namespace App\Domain\Outputs;

class ResetPasswordOutput
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message  = $message;
    }

    public function output():array
    {
        return [
            "message" => $this->message,
            "data" => null
        ];
    }



}