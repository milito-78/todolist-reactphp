<?php


namespace Core\DataBase\Interfaces;


use React\Promise\PromiseInterface;

interface DriverInterface
{
    public function query($query, array $params = []) : PromiseInterface;
}