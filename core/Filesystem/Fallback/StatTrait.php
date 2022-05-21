<?php

namespace Core\Filesystem\Fallback;

use Core\Filesystem\Stat;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

trait StatTrait
{
    protected function internalStat(string $path): PromiseInterface
    {
        if (!file_exists($path)) {
            return resolve(null);
        }

        return resolve(new Stat($path, stat($path)));
    }
}
