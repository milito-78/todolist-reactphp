<?php 

namespace Domain\Common;

use DateTime;

abstract class Entity{
    public ?DateTime $created_at;
    public ?DateTime $updated_at;


    protected function setUpdatedAt($data) {
        $this->updated_at   = isset($data["updated_at"]) && !is_null($data["updated_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["updated_at"]) : null;
    }

    protected function setCreatedAt($data) {
        $this->created_at   = isset($data["created_at"]) && !is_null($data["created_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["created_at"]) : null; 
    }

    public function getCreatedAtDateTimeString()
    {
        return $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null;
    }

    public function getUpdatedAtDateTimeString()
    {
        return $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null;
    }

    abstract public function toArray() : array;
}