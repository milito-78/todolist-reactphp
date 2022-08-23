<?php


namespace Persistence\Users;

use Application\Interfaces\Persistence\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email);

    public function findByToken(string $token);
}