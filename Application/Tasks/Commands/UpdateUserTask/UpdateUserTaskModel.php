<?php
namespace Application\Tasks\Commands\UpdateUserTask;

class UpdateUserTaskModel{
    public function __construct(
        public string $title,
        public string $description,
        public ?string $deadline,
        public ?string $image
    )
    {
       
    }

    public function toArray()
    {
        return [
            "title"       => $this->title,
            "description" => $this->description,
            "deadline"    => $this->deadline,
            "image_path"  => $this->image,
        ];
    }
}