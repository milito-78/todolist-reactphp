<?php
namespace Persistence\Tasks;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateModel;
use Domain\Tasks\Task;
use NilPortugues\Sql\QueryBuilder\Syntax\OrderBy;
use Persistence\Shared\DataBase\Builder;
use Persistence\Shared\Repository;
use React\Promise\PromiseInterface;
use function React\Promise\reject;

class TaskRepository extends Repository implements TaskRepositoryInterface
{
    private int $per_page = 20;

    public function table(): string
    {
        return "tasks";
    }

    public function getByPaginateQuery( string $filter, int $page): PromiseInterface
    {
        $query = $this->_query()
            ->select()
            ->where();
        $query = $this->filterByTime($query,$filter);
        return $query->simplePaginate($this->per_page,$page);
    }

    public function getByForUserPaginateQuery(int $user, string $filter, int $page): PromiseInterface
    {
        $query = $this->_query()
            ->select()
            ->where();
        $query = $this->filterByUser($query,$user);
        $query = $this->filterByTime($query,$filter);
        return $query->simplePaginate($this->per_page,$page);
    }

    public function getTaskForUser($task_id,$user_id): PromiseInterface
    {
        $query = $this->_query()->where()
            ->equals("id",$task_id);
        $query = $this->filterByUser($query,$user_id);
        return $query->end()
            ->first();
    }

    private function filterByUser(Builder $query,int $user_id) :Builder
    {
        return $query->equals("user_id",$user_id);
    }

    private function filterByTime(Builder $query,?string $time) :Builder
    {
        if($time == GetByPaginateModel::Filter_Deadline) {
            $query = $query->isNotNull("deadline")
                ->isNull("deleted_at")
                ->end();
        } elseif($time == GetByPaginateModel::Filter_Time){
            $query = $query->between("deadline",date("Y-m-d")." 00:00:00" ,date("Y-m-d")." 23:59:59")
                ->isNull("deleted_at")
                ->end();
        }else{
            $query = $query->isNull("deleted_at")
                ->end()
                ->orderBy("ISNULL(tasks.deadline)", OrderBy::ASC, '')
                ->orderBy("created_at");
        }
        return $query->orderBy("deadline");
    }

}