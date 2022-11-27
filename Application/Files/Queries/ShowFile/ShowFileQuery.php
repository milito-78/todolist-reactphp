<?php
namespace Application\Files\Queries\ShowFile;

use Infrastructure\Files\Entities\File;
use Infrastructure\Files\Exceptions\FileNotFoundException;
use Infrastructure\Files\Storage;
use React\Promise\ExtendedPromiseInterface;


class ShowFileQuery implements IShowFileQuery{
    /**
     */
    public function __construct() {
    }
    
	/**
	 * @param string $path
	 * @return \React\Promise\ExtendedPromiseInterface
	 */
	public function Execute(string $path): ExtendedPromiseInterface {
        return Storage::get($path)
                    ->then(
                        function (File $file) {
                            return $file;
                        }
                    )->otherwise(
                        function (FileNotFoundException $exception) {
                            return null;
                        }
                    );
	}
}