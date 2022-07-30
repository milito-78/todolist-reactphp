<?php


namespace App\Infrastructure\Repositories;


use React\Promise\PromiseInterface;

interface RepositoryInterface
{
    public function all(array $fields = ["*"]):PromiseInterface;

    public function create(array $data):PromiseInterface;

    public function update(int $id,array $data):PromiseInterface;

    public function delete(int $id):PromiseInterface;

    public function find(int $id,array $fields = ["*"]):PromiseInterface;

    public function findBy(string $field,string $value,array $fields = ["*"]):PromiseInterface;
}