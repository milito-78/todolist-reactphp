<?php

namespace Core\Filesystem;


interface PollInterface
{
    public function activate(): void;

    public function deactivate(): void;
}
