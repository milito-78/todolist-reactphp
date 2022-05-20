<?php


namespace App\Core\Repositories;

use App\Common\Repositories\Repository;

class UploadRepository extends Repository implements UploadRepositoryInterface
{
    public function table(): string
    {
        return "uploads";
    }


}