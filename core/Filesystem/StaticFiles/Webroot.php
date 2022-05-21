<?php

namespace Core\Filesystem\StaticFiles;

use Narrowspark\MimeType\MimeTypeFileExtensionGuesser;
use Core\Filesystem\AdapterInterface;
use Core\Filesystem\Node\FileInterface;
use React\Promise\PromiseInterface;


final class Webroot
{
    private AdapterInterface $filesystem;

    private string $projectRoot;

    public function __construct()
    {
        $this->filesystem = filesystem();
        $this->projectRoot = __ROOT__;
    }

    public function file(string $path): PromiseInterface
    {
        $file = $this->filesystem->file($this->projectRoot . $path);
        return $file->stat()->then(function () use ($file) {
                    return $this->readFile($file);
                }, function () {
                    throw new FileNotFound();
                });
    }

    private function readFile(FileInterface $file): PromiseInterface
    {
        return $file->getContents()
            ->then(
                function ($contents) use ($file) {
                    $mimeType = MimeTypeFileExtensionGuesser::guess($file->path() . $file->name());
                    return new File($contents, $mimeType);
                }
            );
    }
}