<?php


namespace App\Domain\Repositories;


use App\Domain\Context\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail($email);
}