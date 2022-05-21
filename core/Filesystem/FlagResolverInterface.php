<?php

namespace Core\Filesystem;

interface FlagResolverInterface
{
    /**
     * @return int
     */
    public function defaultFlags();

    /**
     * @return array
     */
    public function flagMapping();
}
