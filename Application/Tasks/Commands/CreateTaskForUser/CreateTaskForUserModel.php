<?php


namespace Application\Tasks\Commands\CreateTaskForUser;


class CreateTaskForUserModel
{
    private int     $user_id;
    private string  $title;
    private string  $description;
    private string  $deadline;
    private string  $image;

    public function __construct(int $user_id ,string $title,string $description,string $deadline,string $image )
    {
        $this->user_id      = $user_id;
        $this->title        = $title;
        $this->description  = $description;
        $this->deadline     = $deadline;
        $this->image        = $image;
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