<?php 

namespace Service;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Interfaces\Persistence\UserRepositoryInterface;
use Application\Tasks\Queries\GetTaskById\GetTaskByIdQuery;
use Application\Tasks\Queries\GetTaskById\GetTaskByIdQueryInterface;
use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateQuery;
use Application\Tasks\Queries\GetTasksWithPaginate\GetByPaginateQueryInterface;
use Application\Users\Queries\GetUserByToken\GetByTokenQuery;
use Application\Users\Queries\GetUserByToken\GetByTokenQueryInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class ServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    
    public function provides(string $id): bool
    {
        $services = [
            GetByPaginateQueryInterface::class,
            GetByPaginateQuery::class,
            GetByTokenQueryInterface::class,
            GetByTokenQuery::class,
            GetTaskByIdQueryInterface::class,
            GetTaskByIdQuery::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()
            ->add( GetByPaginateQueryInterface::class, function (){
                return new GetByPaginateQuery($this->getContainer()->get(TaskRepositoryInterface::class));
            });
        $this->getContainer()
            ->add( GetByTokenQueryInterface::class, function (){
                return new GetByTokenQuery($this->getContainer()->get(UserRepositoryInterface::class));
            });
        $this->getContainer()
            ->add( GetTaskByIdQueryInterface::class, function (){
                return new GetTaskByIdQuery($this->getContainer()->get(TaskRepositoryInterface::class));
            });
    }

    public function boot(): void
    {
        
    }

}