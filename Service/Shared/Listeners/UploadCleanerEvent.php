<?php
namespace Service\Shared\Listeners;

use Application\Files\Commands\Delete\IDeleteCommand;

class UploadCleanerEvent
{

    public function __construct(
        private IDeleteCommand $command
    )
    {
    }

    public function __invoke($image_path)
    {
        $this->command->Execute($image_path)
                      ->then(function (bool $res) use ($image_path){
                          echo $image_path . " photo delete from database status : " . ($res? "true" : "false"). "\n";
                      });
    }
}