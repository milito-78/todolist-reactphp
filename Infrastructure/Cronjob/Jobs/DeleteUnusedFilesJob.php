<?php
namespace Infrastructure\Cronjob\Jobs;

use Application\Files\Commands\DeleteExpiredFiles\IDeleteExpiredFilesCommand;

class DeleteUnusedFilesJob{
    public function __construct(
        private IDeleteExpiredFilesCommand $command
    )
    {
    }


    public function __invoke()
    {
        echo "Remove extra files cron job. Starts at : " . date("Y-m-d H:i:s") . "\n";
        $this->command->Execute();
    }
}