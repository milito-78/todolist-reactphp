<?php

namespace Infrastructure\Files;

use Application\Interfaces\Infrastructure\Files\FileUploadInterface;
use Psr\Http\Message\UploadedFileInterface;
use function React\Promise\resolve;

class FileUpload extends FileAbstract implements FileUploadInterface{

    private UploadedFileInterface $file;
    private string $direction;

    public function __construct(UploadedFileInterface $file, string $dir = "")
    {
        $this->file = $file;
        $this->direction = $dir;
    }

    public function execute() {
        $name       = $this->makeFileName($this->file);
        $uploadPath = $this->projectRoot . '/' . $this->makeFilePath($this->direction);

        if (!is_dir($uploadPath)) 
        {
            mkdir($uploadPath);
        }

        $fullPath =  $uploadPath . $name;

        $content = (string)$this->file->getStream();
        file_put_contents($fullPath,$content);
        return resolve($name);    
    }


    private function makeFileName(UploadedFileInterface $file) :string
    {
        preg_match('/^.*\.(.+)$/', $file->getClientFilename(), $filenameParsed);
        $name = md5(uniqid(rand(), true));
        return implode(
            '',
            [
                $name,
                '.',
                $filenameParsed[1],
            ]
        );
    }
}