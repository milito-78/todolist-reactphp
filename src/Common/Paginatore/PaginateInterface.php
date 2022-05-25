<?php

namespace App\Common\Paginatore;


use React\Promise\PromiseInterface;

interface PaginateInterface
{
    public function simplePaginate($per_page = 20, $page = 1, array $fields = ["*"]);

}