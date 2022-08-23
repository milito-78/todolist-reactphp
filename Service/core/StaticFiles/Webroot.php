<?php

namespace Core\StaticFiles;

use React\Promise\PromiseInterface;

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
        $filesystem = filesystem();

        $file = $filesystem->file($this->projectRoot . $path);

        if(!file_exists($file->path() . $file->name()))
            return reject(new FileNotFound());

        $mimeType = mime_content_type($file->path() . $file->name());
        $contents = file_get_contents($file->path() . $file->name());

        return resolve(new File($contents,$mimeType));

    }

}