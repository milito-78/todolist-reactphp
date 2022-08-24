<?php
namespace Domain\Files;

use DateTime;
use Domain\Common\Entity;

class Upload extends Entity{
    public int $id;
    public string $image_name;
    public function __construct(array $data)
    {
        $this->id           = $data["id"];
        $this->image_name   = $data["image_name"];
        
        $this->setCreatedAt($data);
        $this->setUpdatedAt($data);
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
 
}