<?php


namespace Core\DataBase\Paginatore;


use JetBrains\PhpStorm\ArrayShape;

trait SimplePaginatoreTrait
{
    private function makePaginateCount($page,$per_page): array
    {
        $page -= 1;
        $start = $page * (++$per_page);
        $start = $start <= 0 ? 0 : $start - 1;

        return [$start,$per_page];
    }

    #[ArrayShape(["page" => "", "first_page" => "int", "next_page" => "int", "per_page" => "", "count" => "int", "result" => ""])]
    private function simplePaginateResponse(array $result,int $per_page,int $page,int $last_element): array
    {
        $result_count = count($result);
        $next_page_exists = false;

        if ($result_count == $last_element)
        {
            $next_page_exists = true;
            unset($result[--$result_count]);
        }

        return [
            "page"          => $page,
            "first_page"    => 1,
            "next_page"     => $next_page_exists ? $page + 1 : 0,
            "per_page"      => $per_page,
            "count"         => $result_count,
            "result"        => $result
        ];
    }

    #[ArrayShape(["page" => "", "first_page" => "int", "next_page" => "int", "last_page" => "int", "per_page" => "", "count" => "int", "result" => ""])]
    private function paginateResponse(string $route,array $result,int $per_page,int $page,int $all_count):array
    {
        $next_page_exists = false;
        $last_page = ceil ($all_count / $per_page);

        if ($last_page != $page)
            $next_page_exists = true;

        return [
            "page"          => $page,
            "first_page"    => 1,
            "next_page"     => $next_page_exists ? $page + 1 : 0,
            "last_page"     => $last_page,
            "per_page"      => $per_page,
            "count"         => count($result),
            "result"        => $result
        ];
    }
}