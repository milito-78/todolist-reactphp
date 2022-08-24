<?php


namespace Domain\Users;

use DateTime;
use Domain\Common\Entity;

class User extends Entity
{
    public int $id;
    public string $full_name;
    public string $email;
    public string $password;
    public string $api_key;
    public ?DateTime $deleted_at;

    public function __construct(array $data)
    {
        $this->id           = $data["id"];
        $this->full_name    = $data["full_name"];
        $this->email        = $data["email"];
        $this->password     = $data["password"];
        $this->api_key      = $data["api_key"];
        $this->setCreatedAt($data);
        $this->setUpdatedAt($data);
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

    public function getDeletedAtDateTimeString()
    {
        return $this->deleted_at ? $this->deleted_at->format("Y-m-d H:i:s") : null;
    }

}