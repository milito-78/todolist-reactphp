<?php


namespace App\Core\Repositories;


use App\Infrastructure\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email);

    public function findByToken(string $token);
}