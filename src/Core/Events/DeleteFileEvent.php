<?php


namespace App\Core\Events;

use App\Infrastructure\Files\Cleaner;

class DeleteFileEvent
{
    private Cleaner $cleaner;

    public function __construct(Cleaner $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    public function __invoke($image_path,$dir = "")
    {
        $this->cleaner->remove($image_path,$dir)->then(function (bool $result) use($image_path){
            echo $image_path . " file delete status : " . ($result? "true" : "false"). "\n";
        });
    }
}