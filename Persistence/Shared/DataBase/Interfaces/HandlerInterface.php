<?php


namespace Persistence\Shared\DataBase\Interfaces;


interface HandlerInterface
{
    public function getDriver() : DriverInterface;
}