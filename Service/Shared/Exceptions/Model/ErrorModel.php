<?php

namespace Service\Shared\Exceptions\Model;

use JetBrains\PhpStorm\ArrayShape;

final class ErrorModel{

    public string $title;

    public array $message;

    public function __construct(string $title ,$message = [])
    {
        $this->title = $title;
        $this->message = $message;
    }


    #[ArrayShape(["title" => "", "errors" => "array|mixed"])]
    public static function error($title , $message = []): array
    {
        return [
            "title" => $title,
            "errors" => $message
        ];
    }

    #[ArrayShape(["title" => "string", "errors" => "array"])]
    public function toArray(): array
    {
        return [
            "title"     => $this->title,
            "errors"    => $this->message
        ];
    }
}