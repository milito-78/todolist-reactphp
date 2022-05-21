<?php 
namespace App\Domain\Outputs;

use App\Common\Files\Uploader;
use App\Domain\Entities\Upload;

class ImageUploadOutput{

    private Upload $image;

    public function __construct(Upload $image)
    {
        $this->image = $image;
    }

    public function output():array
    {
        return [
            "message" => "Image uploaded successfully",
            "data" => [
                "image" => [
                    "id"            => $this->image->id,
                    "image_name"    => $this->image->image_name,
                    "image_path"    => Uploader::getImagePath($this->image->image_name),
                ]
            ]
        ];
    }
}