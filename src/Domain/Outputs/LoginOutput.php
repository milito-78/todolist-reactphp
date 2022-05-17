<?php 
namespace App\Domain\Outputs;

use App\Domain\Entities\User;

class LoginOutput{

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function output():array
    {
        return [
            "message" => "Login completed successfully",
            "data" => [
                "user" => [
                    "id"            => $this->user->id,
                    "full_name"     => $this->user->full_name,
                    "email"         => $this->user->email,
                    "api_key"       => $this->user->api_key,
                ]
            ]
        ];
    }
}