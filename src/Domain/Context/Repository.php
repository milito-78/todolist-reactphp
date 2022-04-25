<?php


namespace App\Domain\Context;


use Core\DataBase\Interfaces\DatabaseInterface;
use React\Promise\PromiseInterface;

abstract class Repository implements RepositoryInterface
{
    private DatabaseInterface $database;
    private string $table = "";

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
        $this->setTable($this->table());
    }


    abstract public function table(): string;


    /**
     * @param string $table
     * @return Repository
     */
    public function setTable(string $table): Repository
    {
        $this->table = $table;
        return $this;
    }

    public function all(array $fields = ["*"]): PromiseInterface
    {
        return $this->database->all($this->table, $fields);
    }

    public function create(array $data): PromiseInterface
    {
        return $this->database->create($this->table,$data);
    }

    public function update(int $id, array $data): PromiseInterface
    {
        return $this->database->update($this->table, $id, $data );
    }

    public function delete(int $id): PromiseInterface
    {
        return $this->database->delete($this->table,$id);
    }

    public function find(int $id, array $fields = ["*"]): PromiseInterface
    {
        return $this->database->find($this->table,$id,$fields);
    }

    public function findBy(string $field, string $value, array $fields = ["*"]): PromiseInterface
    {
        return $this->database->findBy($this->table,$field,$value,$fields);
    }

    public function query($query, array $params = []): PromiseInterface
    {
        return $this->database->query($query,$params);
    }
}