<?php

namespace Core\DataBase;


class DB
{
    /**
     * @var DBConnection|null
     */
    protected $db = null;


    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function __invoke(): DBConnection
    {
        if (!$this->db)
            return (new self())->db;
        return $this->db;
    }


}