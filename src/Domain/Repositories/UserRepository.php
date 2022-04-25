<?php


namespace App\Domain\Repositories;

use App\Domain\Context\Repository;
use Core\DataBase\Interfaces\DatabaseInterface;
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


}