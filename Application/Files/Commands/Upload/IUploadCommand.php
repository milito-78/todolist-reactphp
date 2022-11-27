<?php
namespace Application\Files\Commands\Upload;

use Psr\Http\Message\UploadedFileInterface;
use React\Promise\PromiseInterface;

interface IUploadCommand{
    public function Execute(UploadedFileInterface $file) : PromiseInterface;
}