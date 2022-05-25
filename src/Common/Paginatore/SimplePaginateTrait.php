<?php


namespace App\Common\Paginatore;


use React\Promise\PromiseInterface;

class SimplePaginateTrait
{

    public function simplePaginate($per_page = 20, $page = 1, array $fields = ["*"]): PromiseInterface
    {
        $this->database->limit($this->table,$per_page + 1 ,$page,$fields)
            ->then(function (array $result) use ($page,$per_page)
            {
                if ( count($result) == $per_page + 1 && key_exists($per_page,$result))
                {

                }

            });
    }
}