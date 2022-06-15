<?php


namespace App\Core\Repositories;

use App\Common\Repositories\RepositoryInterface;
use React\Promise\PromiseInterface;

interface UploadRepositoryInterface extends RepositoryInterface
{
    public function deleteByName($name):PromiseInterface;
}