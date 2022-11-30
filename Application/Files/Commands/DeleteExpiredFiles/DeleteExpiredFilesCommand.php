<?php
namespace Application\Files\Commands\DeleteExpiredFiles;

use Application\Interfaces\Persistence\UploadRepositoryInterface;

class DeleteExpiredFilesCommand implements IDeleteExpiredFilesCommand{
    

    /**
     */
    public function __construct(
        private UploadRepositoryInterface $uploadRepository
    )
    {
    }

	/**
	 * @return mixed
	 */
	public function Execute() {
        $this->uploadRepository->getExpiredFiles()->then(function ($images) {
            foreach ($images as $image)
            {
                $this->uploadRepository->delete($image["id"])->then(function ($res) use($image){
                    echo $image["id"] . " photo delete from database status : " . ($res? "true" : "false") . "\n";
                });
            }
        });
	}
}