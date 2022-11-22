<?php


namespace Persistence\Users;

use Application\Interfaces\Persistence\UserRepositoryInterface;
use Domain\Users\User;
use Persistence\Shared\Repository;
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

    public function updateByEmail(string $email,array $data): PromiseInterface
    {
        return $this->_query()->fetch([ "email" => $email ], $data );
    }

}