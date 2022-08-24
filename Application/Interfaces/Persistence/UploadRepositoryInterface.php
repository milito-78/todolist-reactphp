<?php

namespace Application\Interfaces\Persistence;

use React\Promise\PromiseInterface;

interface UploadRepositoryInterface extends RepositoryInterface
{
    public function deleteByName($name):PromiseInterface;

    public function getExpiredFiles() :PromiseInterface;
}