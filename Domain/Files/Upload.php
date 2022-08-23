<?php
namespace Domain\Files;

use DateTime;

class Upload{
    public int $id;
    public string $image_name;
    public ?DateTime $created_at;
    public ?DateTime $updated_at;
    public function __construct(array $data)
    {
        $this->id           = $data["id"];
        $this->image_name   = $data["image_name"];
        $this->created_at   = isset($data["created_at"]) && !is_null($data["created_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["created_at"]) : null; 
        $this->updated_at   = isset($data["updated_at"]) && !is_null($data["updated_at"]) ? DateTime::createFromFormat("Y-m-d H:i:s",$data["updated_at"]) : null;
    }
    
    public function toArray() : array
    {
        return [
            "id"            => $this->id,
            "image_name"    => $this->image_name,
            "created_at"    => $this->getCreatedAtDateTimeString(),
            "updated_at"    => $this->getUpdatedAtDateTimeString(),
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
}