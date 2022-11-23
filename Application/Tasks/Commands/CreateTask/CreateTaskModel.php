<?php
namespace Application\Tasks\Commands\CreateTask;

class CreateTaskModel{

    public function __construct(
        public int $user_id,
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
            "user_id"     => $this->user_id,
        ];
    }
}