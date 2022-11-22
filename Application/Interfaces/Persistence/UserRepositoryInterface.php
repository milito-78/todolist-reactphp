<?php

namespace Application\Interfaces\Persistence;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email);

    public function findByToken(string $token);

    public function updateByEmail(string $email,array $data);
}