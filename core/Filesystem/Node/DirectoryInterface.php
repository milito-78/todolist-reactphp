<?php

namespace Core\Filesystem\Node;

use React\Promise\PromiseInterface;

interface DirectoryInterface extends NodeInterface
{
    /**
     * @return PromiseInterface<array<NodeInterface>>
     */
    public function ls(): PromiseInterface;
}
