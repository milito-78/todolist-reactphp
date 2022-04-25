<?php


namespace Core\DataBase\Interfaces;


interface HandlerInterface
{
    public function getDriver() : DriverInterface;
}