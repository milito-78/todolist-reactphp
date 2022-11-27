<?php
namespace Domain\Files;

use DateTime;
use Domain\Common\Entity;

class Upload extends Entity{
    public int $id;
    public string $image_name;
    public string $image_path;
    public function __construct(array $data)
    {
        $this->id           = $data["id"];
        $this->image_name   = $data["image_name"];
        $this->image_path   = $this->getImagePath();
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
    
    private function getImagePath(){
        return envGet("APP_URL") . ":" . envGet("SOCKET_PORT") . "/" . envGet("STORAGE_PATH") . "/" . $this->image_name;
    }
}