<?php

namespace Infrastructure\Files;

abstract class FileAbstract{
    const UPLOADS_DIR               = "storage/public";
    protected string $projectRoot   = __ROOT__;

    protected function makeFilePath($name): string
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