<?php


namespace App\Domain\Entities;

use DateTime;

class User
{
    public int $id;
    public string $full_name;
    public string $email;
    public string $password;
    public string $api_key;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public ?DateTime $deleted_at;

    public function __construct(array $data)
    {
        $this->id           = $data["id"];
        $this->full_name    = $data["full_name"];
        $this->email        = $data["email"];
        $this->password     = $data["password"];
        $this->api_key      = $data["api_key"];
        $this->created_at   = isset($data["created_at"]) && !is_null($data["created_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["created_at"]) : null;
        $this->updated_at   = isset($data["updated_at"]) && !is_null($data["updated_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["updated_at"]) : null;
        $this->deleted_at   = isset($data["deleted_at"]) && !is_null($data["deleted_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["deleted_at"]) : null;
    }

    public function toArray() : array
    {
        return [
            "id"         => $this->id,
            "full_name"  => $this->full_name,
            "email"      => $this->email,
            "api_key"    => $this->api_key,
            "created_at" => $this->getCreatedAtDateTimeString(),
            "updated_at" => $this->getUpdatedAtDateTimeString(),
            "deleted_at" => $this->getDeletedAtDateTimeString(),
        ];
    }

    public function getCreatedAtDateTimeString()
    {
        return $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null;
    }

    public function getUpdatedAtDateTimeString()
    {
        return $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null;
    }

    public function getDeletedAtDateTimeString()
    {
        return $this->deleted_at ? $this->deleted_at->format("Y-m-d H:i:s") : null;
    }

}