<?php
namespace Application\Interfaces\Persistence;

use React\Promise\PromiseInterface;

interface ICodeRepository{
    public function saveCode(string $key, string $code,int $expire = null): PromiseInterface;

    public function getCode(string $key): PromiseInterface;

    public function deleteCode(string $key): PromiseInterface;
}