<?php


namespace App\Core\Repositories;

use App\Infrastructure\Repositories\RepositoryInterface;
use React\Promise\PromiseInterface;

interface UploadRepositoryInterface extends RepositoryInterface
{
    public function deleteByName($name):PromiseInterface;

    public function getExpiredFiles() :PromiseInterface;
}