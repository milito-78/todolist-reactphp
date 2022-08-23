<?php


namespace Persistence\Files;

use Application\Interfaces\Persistence\RepositoryInterface;

use React\Promise\PromiseInterface;

interface UploadRepositoryInterface extends RepositoryInterface
{
    public function deleteByName($name):PromiseInterface;

    public function getExpiredFiles() :PromiseInterface;
}