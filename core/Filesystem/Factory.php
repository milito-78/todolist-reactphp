<?php

namespace Core\Filesystem;

use Core\Filesystem\Uv\Adapter;
use React\EventLoop\ExtUvLoop;
use React\EventLoop\Loop;
use Core\Filesystem\ChildProcess;

final class Factory
{
    public static function create(): AdapterInterface
    {
        if (\function_exists('uv_loop_new') && Loop::get() instanceof ExtUvLoop) {
            return new Adapter();
        }

        if (DIRECTORY_SEPARATOR !== '\\') {
            return new ChildProcess\Adapter();
        }

        return new Fallback\Adapter();
    }
}
