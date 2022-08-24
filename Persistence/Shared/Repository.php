<?php


namespace Persistence\Shared;

use Application\Interfaces\Persistence\RepositoryInterface;
use Persistence\Shared\DataBase\Builder;
use React\Promise\PromiseInterface;

abstract class Repository implements RepositoryInterface
{
    private string $table = "";

    public function __construct()
    {
        $this->setTable($this->table());
    }

    abstract public function table(): string;

    public function setTable(string $table): Repository
    {
        $this->table = $table;
        return $this;
    }

    public function all(array $fields = ["*"]): PromiseInterface
    {
        return $this->_query()->select($fields)->get();
    }

    public function create(array $data): PromiseInterface
    {
        return $this->_query()->table($this->table)->insert($data);
    }

    public function update(int $id, array $data): PromiseInterface
    {
        return $this->_query()->fetch([ "id" => $id ], $data );
    }

    public function delete(int $id): PromiseInterface
    {
        return $this->_query()->remove([ "id" => $id ]);
    }

    public function find(int $id, array $fields = ["*"]): PromiseInterface
    {
        return $this    ->_query()
                        ->select($fields)
                        ->where()
                        ->equals("id",$id)
                        ->end()
                        ->first();
    }

    public function findBy(string $field, string $value, array $fields = ["*"]): PromiseInterface
    {
        return $this->_query()
                        ->select($fields)
                        ->where()
                        ->equals($field,$value)
                        ->end()->first();
    }

    public function _query(): Builder
    {
        return Builder::query()->table($this->table);
    }

}