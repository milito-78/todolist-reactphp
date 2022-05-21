<?php

namespace Core\Filesystem\ChildProcess;

use Core\Filesystem\AdapterInterface;
use Core\Filesystem\ModeTypeDetector;
use Core\Filesystem\Stat;
use React\Promise\PromiseInterface;
use Core\Filesystem\Node;

/**
 * @internal
 */
final class Adapter implements AdapterInterface
{
    use StatTrait;

    public function detect(string $path): PromiseInterface
    {
        return $this->internalStat($path)->then(function (?Stat $stat) use ($path) {
            if ($stat === null) {
                return new NotExist($this, dirname($path) . DIRECTORY_SEPARATOR, basename($path));
            }

            switch (ModeTypeDetector::detect($stat->mode())) {
                case Node\DirectoryInterface::class:
                    return $this->directory($stat->path());
                    break;
                case Node\FileInterface::class:
                    return $this->file($stat->path());
                    break;
                default:
                    return new Node\Unknown($stat->path(), $stat->path());
                    break;
            }
        });
    }

    public function directory(string $path): Node\DirectoryInterface
    {
        return new Directory($this,dirname($path) . DIRECTORY_SEPARATOR, basename($path));
    }

    public function file(string $path): Node\FileInterface
    {
        return new File(dirname($path) . DIRECTORY_SEPARATOR, basename($path));
    }
}
