<?php


namespace App\Core\CornJobs;

use App\Core\Repositories\UploadRepositoryInterface;

class RemoveExtraFilesJob
{
    public function __invoke()
    {
        /** @var UploadRepositoryInterface $uploadRepository */
        $uploadRepository = container()->get(UploadRepositoryInterface::class);
        echo "Remove extra files cron job. Starts at : " . date("Y-m-d H:i:s") . "\n";

        $uploadRepository->getExpiredFiles()->then(function ($images) use ($uploadRepository){
            foreach ($images as $image)
            {

                $uploadRepository->delete($image["id"])->then(function ($res) use($image){
                    echo $image["id"] . " photo delete from database status : " . ($res? "true" : "false") . "\n";
                });
            }
        });
    }

}