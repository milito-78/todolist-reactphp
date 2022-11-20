<?php


namespace Domain\Tasks;

use DateTime;
use Domain\Common\Entity;

class Task extends Entity
{
    public int $id;
    public string $title;
    public string $description;
    public int $user_id;
    public ?string $image_path;
    public ?DateTime $deadline;
    public ?DateTime $deleted_at;

    public function __construct(array $data)
    {
        $this->id           = $data["id"];
        $this->title        = $data["title"];
        $this->description  = $data["description"];
        $this->user_id      = $data["user_id"];
        $this->image_path   = $data["image_path"];
        $this->setCreatedAt($data);
        $this->setUpdatedAt($data);
        $this->deadline     = isset($data["deadline"]) && !is_null($data["deadline"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["deadline"]) : null;
        $this->deleted_at   = isset($data["deleted_at"]) && !is_null($data["deleted_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["deleted_at"]) : null;
    }

    public function toArray() : array
    {
        return [
            "id"            => $this->id,
            "title"         => $this->title,
            "description"   => $this->description,
            "user_id"       => $this->user_id,
            "image_path"    => $this->image_path,
            "deadline"      => $this->getDeadlineDateTimeString(),
            "created_at"    => $this->getCreatedAtDateTimeString(),
            "updated_at"    => $this->getUpdatedAtDateTimeString(),
            "deleted_at"    => $this->getDeletedAtDateTimeString(),
        ];
    }


    public function getDeletedAtDateTimeString(): ?string
    {
        return $this->deleted_at ? $this->deleted_at->format("Y-m-d H:i:s") : null;
    }

    public function getDeadlineDateTimeString(): ?string
    {
        return $this->deadline ? $this->deadline->format("Y-m-d H:i:s") : null;
    }

}