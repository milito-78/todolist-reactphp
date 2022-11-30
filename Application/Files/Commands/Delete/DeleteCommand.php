<?php
namespace Application\Files\Commands\Delete;

use Application\Interfaces\Persistence\UploadRepositoryInterface;
use React\Promise\ExtendedPromiseInterface;

class DeleteCommand implements IDeleteCommand{
    public function __construct(
        private UploadRepositoryInterface $uploadRepository
    )
    {
        
    }

    public function Execute(string $image_path) : ExtendedPromiseInterface{
        return $this->uploadRepository->deleteByName($image_path);
    }
}