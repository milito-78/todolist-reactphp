<?php
namespace Application\Files\Commands\Upload;

use Application\Interfaces\Persistence\UploadRepositoryInterface;
use Domain\Files\Upload;
use Infrastructure\Files\Storage;
use Psr\Http\Message\UploadedFileInterface;
use React\Promise\PromiseInterface;

class UploadCommand implements IUploadCommand{

    /**
     */
    public function __construct(private UploadRepositoryInterface $uploadRepository) {
    }

	/**
	 * @param \Psr\Http\Message\UploadedFileInterface $file
	 * @return \React\Promise\PromiseInterface
	 */
	public function Execute(UploadedFileInterface $file): PromiseInterface {
        return Storage::put($file)
                        ->then(function($image_name){
                            return $this->uploadRepository->create([
                                "image_name" => $image_name
                            ])
                            ->then(function($image){
                                return new Upload($image);
                            });
                        });
	}
}