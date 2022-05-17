<?php


namespace App\Core\Repositories;


use App\Common\Repsitories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email);

    public function findByToken(string $token);
}