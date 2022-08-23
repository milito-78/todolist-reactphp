<?php

namespace Infrastructure\Files;

use Application\Interfaces\Infrastructure\Files\FileRemoveInterface;
use function React\Promise\resolve;

class FileRemove extends FileAbstract implements FileRemoveInterface{
    private string $file ;
    private string $directory ;

    public function __construct(string $file_name,string $dir = "")
    {
        $this->file         = $file_name;
        $this->directory    = $dir;
    }

    public function execute(){
        $uploadPath = $this->projectRoot . '/' . $this->makeFilePath($this->directory);

        $fullPath =  $uploadPath . $this->file;

        if(file_exists($fullPath))
        {
            unlink($fullPath);
            return resolve(true);
        }
        return resolve(false);
    }
}