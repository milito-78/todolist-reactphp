<?php

namespace App\Common\Files;

use Psr\Http\Message\UploadedFileInterface;
use Core\Filesystem\AdapterInterface;

class Uploader{
    const UPLOADS_DIR = "storage/public";
    private string $projectRoot = __ROOT__;

    private AdapterInterface $filesystem;

    public function __construct(AdapterInterface $adapter)
    {
        $this->filesystem = $adapter;
    }

    public function upload(UploadedFileInterface $file, $dir = "/")
    {
        $name = $this->makeFileName($file);

        $uploadPath = $this->makeFilePath($file,$name);


        /*if (!file_exists($this->projectRoot . $dir)) {
            mkdir($this->projectRoot . $dir);
        }*/

        $fullPath = $this->projectRoot . $dir . $uploadPath;

        return $this->filesystem->file($fullPath)
            ->putContents((string)$file->getStream())
            ->then(
                function () use ($name)
                {
                    return $name;
                }
            );
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

    private function makeFilePath(UploadedFileInterface $file,$name): string
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

    public static function getImagePath($image)
    {
        return config("app.url") . "/" . self::UPLOADS_DIR . "/" . $image;
    }
}