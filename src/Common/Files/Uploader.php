<?php

namespace App\Common\Files;

use Psr\Http\Message\UploadedFileInterface;
use function React\Promise\resolve;

class Uploader
{
    const UPLOADS_DIR           = "storage/public";
    private string $projectRoot = __ROOT__;

    public function upload(UploadedFileInterface $file, $dir = "")
    {
        $name       = $this->makeFileName($file);
        $uploadPath = $this->projectRoot . '/' . $this->makeFilePath($dir);

        if (!is_dir($uploadPath)) 
        {
            mkdir($uploadPath);
        }

        $fullPath =  $uploadPath . $name;

        $content = (string)$file->getStream();
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

    public static function getImagePath($image): string
    {
        return config("app.url") . ":" .config("app.socket_port") . "/" . self::UPLOADS_DIR . "/" . $image;
    }

}