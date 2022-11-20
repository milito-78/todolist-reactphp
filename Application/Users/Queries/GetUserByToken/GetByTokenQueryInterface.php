<?php


namespace Application\Users\Queries\GetUserByToken;


interface GetByTokenQueryInterface
{
    public function Execute(?string $token);
}