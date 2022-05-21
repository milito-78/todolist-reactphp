<?php

namespace Core\Filesystem;

interface TypeDetectorInterface
{
    /**
     * @param AdapterInterface $filesystem
     */
    public function __construct(AdapterInterface $filesystem);

    /**
     * @param array $node
     * @return React\Promise\PromiseInterface
     */
    public function detect(array $node);
}
