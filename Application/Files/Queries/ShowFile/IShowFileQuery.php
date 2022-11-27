<?php
namespace Application\Files\Queries\ShowFile;

use React\Promise\ExtendedPromiseInterface;
use React\Promise\PromiseInterface;

interface IShowFileQuery{
    public function Execute(string $path) : ExtendedPromiseInterface;
}