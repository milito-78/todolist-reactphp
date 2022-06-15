<?php


namespace App\Core\Repositories;

use App\Common\Repositories\Repository;
use Core\DataBase\Builder;
use React\Promise\PromiseInterface;

class UploadRepository extends Repository implements UploadRepositoryInterface
{
    public function table(): string
    {
        return "uploads";
    }


    public function deleteByName($name): PromiseInterface
    {
        return $this->_query()->remove(["image_name" => $name])->then(function ($result){
            return $result;
        });
    }
}