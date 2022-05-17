<?php 
namespace App\Domain\Outputs;

use App\Domain\Entities\User;

class SplashOutput{
    private ?User  $user;
    private array $option;

    public function __construct(array $option,?User $user)
    {
        $this->option   = $option;
        $this->user     = $user;
    }

    public function output():array
    {
        $response = [
            "data" => [
                "user" => null,
                "option" => $this->option
            ]
        ];
        if($this->user){
            $response["user"] = [
                "id"            => $this->user->id,
                "full_name"     => $this->user->full_name,
                "email"         => $this->user->email,
                "api_key"       => $this->user->api_key,
            ];
        }

        return $response;
    }
}