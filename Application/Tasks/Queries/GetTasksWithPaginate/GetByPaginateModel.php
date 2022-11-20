<?php


namespace Application\Tasks\Queries\GetTasksWithPaginate;


class GetByPaginateModel
{
    const Filter_All        = "all";
    const Filter_Deadline   = "deadline";
    const Filter_Time       = "time";

    private int $user_id;
    private int $page;
    private string $filter;

    public function __construct(int $user_id , int $page, string $filter)
    {
        $this->user_id  = $user_id;
        $this->page     = $page;
        $this->filter   = $filter;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getFilter(): string
    {
        return $this->filter;
    }

}