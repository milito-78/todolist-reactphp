<?php

namespace Core\Filesystem\StaticFiles;

final class File
{
    public string $contents;
    public string $mimeType;

    public function __construct(string $contents, string $mimeType)
    {
        $this->contents = $contents;
        $this->mimeType = $mimeType;
    }
}