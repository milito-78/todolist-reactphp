<?php
namespace Application\Files\Commands\DeleteFile;

use Infrastructure\Files\Storage;
use React\Promise\ExtendedPromiseInterface ;

class DeleteFileCommand implements IDeleteFileCommand{
	/**
	 * @param string $image_path
	 * @return \React\Promise\ExtendedPromiseInterface
	 */
    
	public function Execute(string $image_path): ExtendedPromiseInterface{
        return Storage::delete($image_path);
	}
}