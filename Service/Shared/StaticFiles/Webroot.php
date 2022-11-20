<?php

namespace Service\Shared\StaticFiles;

use Infrastructure\Files\File;
use Infrastructure\Files\FileNotFound;
use React\Promise\PromiseInterface;

use Service\Shared\Helpers\Helpers;
use function React\Promise\reject;
use function React\Promise\resolve;

final class Webroot
{
    private string $projectRoot;

    public function __construct()
    {
        
        $this->projectRoot = __ROOT__;
    }

    public function file(string $path): PromiseInterface
    {
        $filesystem = Helpers::filesystem();

        $file = $filesystem->file($this->projectRoot . $path);

        if(!file_exists($file->path() . $file->name()))
            return reject(new FileNotFound());

        $mimeType = mime_content_type($file->path() . $file->name());
        $contents = file_get_contents($file->path() . $file->name());

        return resolve(new File($contents,$mimeType));

    }

}