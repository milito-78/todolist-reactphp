<?php


namespace App\Core\Repositories;

use App\Common\Repositories\Repository;
use React\Promise\PromiseInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function table(): string
    {
        return "users";
    }

    public function findByEmail($email): PromiseInterface
    {
        return $this->findBy("email" , $email);
    }

    public function findByToken(string $token): PromiseInterface
    {
        return $this->findBy("api_key" , $token);
    }

}