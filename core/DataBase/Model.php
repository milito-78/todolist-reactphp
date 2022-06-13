<?php


namespace Core\DataBase;


use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

abstract class Model extends Builder
{
    public static function all(array $fields = ["*"]): PromiseInterface
    {
        $object = container()->get(self::class);

        $query  = $object->select($fields);
        $sql    = $object->builder->write($query->query);
        $values = $object->builder->getValues();
        return $object->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return $result->resultRows;
            });
    }

    public static function create(array $data): PromiseInterface
    {
        $object = container()->get(self::class);
        $query  = $object->builder->insert($object->table,$data);
        $sql    = $object->builder->write($query->query);
        $values = $object->builder->getValues();
        return $object->driver
            ->query($sql,$values)
            ->then(function(QueryResult $result) use ($data){
                $data["id"] = $result->insertId;
                return $data;
            });
    }

    public function update(array $conditions,array $data): PromiseInterface
    {
        $object = container()->get(self::class);
        $query  = $object->builder->update($object->table,$data)->where();
        foreach ($conditions as $field => $value)
            $query->equals($field, $value);
        $query->end();
        $sql    = $object->builder->write($query);
        $values = $object->builder->getValues();
        return $object->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return (bool)$result->affectedRows;
            });
    }

    public static function delete(array $conditions): PromiseInterface
    {
        $object = container()->get(self::class);

        $query  = $object->builder->delete($object->table)->where();
        foreach ($conditions as $field => $value)
            $query->equals($field, $value);
        $query->end();

        $sql    = $object->builder->write($query);
        $values = $object->builder->getValues();

        return $object->driver->query($sql,$values)
            ->then(function(QueryResult $result){
                return (bool)$result->affectedRows;
            });
    }
}