<?php 
namespace Application\Users\Commands\CreateUser;

class CreateUserModel{
    
    /**
     */
    public function __construct(
        public string $email,
        public string $password,
        public string $full_name,
    ) {
    }

    public function toArray(){
        return [
            "full_name" => $this->full_name,
            "email"     => $this->email,
            "password"  => $this->password,
        ];
    }
}