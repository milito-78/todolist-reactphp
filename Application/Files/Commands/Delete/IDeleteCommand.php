<?php
namespace Application\Files\Commands\Delete;

use React\Promise\ExtendedPromiseInterface;

interface IDeleteCommand{
    public function Execute(string $image_path) : ExtendedPromiseInterface;
}