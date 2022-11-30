<?php
namespace Application\Files\Commands\DeleteFile;

use React\Promise\ExtendedPromiseInterface;

interface IDeleteFileCommand{
    public function Execute(string $image_path):ExtendedPromiseInterface;
}