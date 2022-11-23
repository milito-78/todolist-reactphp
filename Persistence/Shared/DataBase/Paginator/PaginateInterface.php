<?php

namespace Persistence\Shared\DataBase\Paginator;


interface PaginateInterface
{
    public function simplePaginate($per_page = 20, $page = 1, array $columns = ["*"]);

    public function paginate(int $per_page = 20,int $page = 1, array $columns = ["*"]);
}