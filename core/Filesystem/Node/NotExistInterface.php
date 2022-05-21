<?php

namespace Core\Filesystem\Node;

use React\Promise\PromiseInterface;

interface NotExistInterface extends NodeInterface
{
    /**
     * @return PromiseInterface<DirectoryInterface>
     */
    public function createDirectory(): PromiseInterface;

    /**
     * @return PromiseInterface<FileInterface>
     */
    public function createFile(): PromiseInterface;
}
