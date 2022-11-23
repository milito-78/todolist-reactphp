<?php
namespace Service\Tasks\Common\Resources;

use Domain\Tasks\Task;
use Service\Shared\Resources\IArrayable;

class TaskResource implements IArrayable{

    /**
     */
    public function __construct(private mixed $task) {
    }

    public function toArray():array {
        /**
         * @var Task $item
         */
        $item = $this->task;
       
        return [
            "id"            => $item->id,
            "title"         => $item->title,
            "description"   => $item->description,
            "image_path"    => $item->image_path,
            "deadline"      => $item->deadline,
            "created_at"    => $item->getCreatedAtDateTimeString(),
            "updated_at"    => $item->getUpdatedAtDateTimeString()
        ];
    }
}