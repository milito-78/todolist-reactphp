<?php


namespace Core\DataBase\Interfaces;


use React\Promise\PromiseInterface;

interface DatabaseInterface
{
    public function connection(string $name): self;

    public function __construct(DriverInterface $driver);

    public function query($query, array $params = []) : PromiseInterface;

    public function all(string $table, array $fields = ["*"]):PromiseInterface;

    public function create(string $table,array $data):PromiseInterface;

    public function update(string $table,int $id,array $data):PromiseInterface;

    public function delete(string $table,int $id):PromiseInterface;

    public function find(string $table,int $id,array $fields = ["*"]):PromiseInterface;

    public function findBy(string $table,string $field,string $value,array $fields = ["*"]): PromiseInterface;

}