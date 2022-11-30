<?php
namespace Service\Shared\Listeners;



use App\Infrastructure\Files\Cleaner;
use Application\Files\Commands\DeleteFile\IDeleteFileCommand;
use Infrastructure\Files\Storage;

class DeleteFileEvent
{
    public function __construct(
        private IDeleteFileCommand $command
    )
    {
    }

    public function __invoke($image_path)
    {
        $this->command
                    ->Execute($image_path)
                    ->then(function (bool $result) use($image_path){
                        echo $image_path . " file delete status : " . ($result? "true" : "false"). "\n";
                    });
    }
}