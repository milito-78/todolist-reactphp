<?php


namespace App\Domain\Outputs;

class CheckCodeOutput
{
    private bool $result;
    private string $message;

    public function __construct(bool $result,string $message)
    {
        $this->result   = $result;
        $this->message  = $message;
    }

    public function output():array
    {
        return [
            "message" => $this->message,
            "data" => [
                "check"         => $this->result
            ]
        ];
    }



}