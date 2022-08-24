<?php


namespace Persistence\Files;

use Application\Interfaces\Persistence\UploadRepositoryInterface;
use Persistence\Shared\Repository;
use React\Promise\PromiseInterface;

class UploadRepository extends Repository implements UploadRepositoryInterface
{
    public function table(): string
    {
        return "uploads";
    }


    public function deleteByName($name): PromiseInterface
    {
        return $this->_query()->remove(["image_name" => $name]);
    }

    public function getExpiredFiles(): PromiseInterface
    {
        return $this->_query()
            ->where()
            ->lessThanOrEqual("created_at",date('Y-m-d H:i:s', (time() - 60 * 30)))
            ->end()
            ->get();
    }
}