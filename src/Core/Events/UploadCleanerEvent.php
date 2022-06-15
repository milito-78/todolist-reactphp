<?php


namespace App\Core\Events;


use App\Core\Repositories\UploadRepositoryInterface;

class UploadCleanerEvent
{
    private UploadRepositoryInterface $uploadRepository;

    public function __construct(UploadRepositoryInterface $uploadRepository)
    {
        $this->uploadRepository = $uploadRepository;
    }

    public function __invoke($image_path)
    {
        $this->uploadRepository->deleteByName($image_path)->then(function ($res) use ($image_path){
            echo $image_path . " photo delete from database status : " . ($res? "true" : "false");
        });
    }
}