<?php

namespace App\Infrastructure\Files;

use Psr\Http\Message\UploadedFileInterface;
use function React\Promise\resolve;
/**
 * TODO make facade for file
*/
class Cleaner
{
    const UPLOADS_DIR           = "storage/public";
    private string $projectRoot = __ROOT__;

    public function remove($file_name, $dir = "")
    {
        $name       = $this->makeFileName($file_name);
        $uploadPath = $this->projectRoot . '/' . $this->makeFilePath($dir);

        if (!is_dir($uploadPath)) 
        {
            mkdir($uploadPath);
        }

        $fullPath =  $uploadPath . $name;

        if(file_exists($fullPath))
        {
            unlink($fullPath);
            return resolve(true);
        }
        return resolve(false);
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

    private function makeFilePath($name): string
    {
        return implode(
            '',
            [
                self::UPLOADS_DIR,
                '/',
                $name,
            ]
        );
    }

}