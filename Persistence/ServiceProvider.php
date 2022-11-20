<?php 

namespace Persistence;

use Application\Interfaces\Persistence\TaskRepositoryInterface;
use Application\Interfaces\Persistence\UploadRepositoryInterface;
use Application\Interfaces\Persistence\UserRepositoryInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Persistence\Files\UploadRepository;
use Persistence\Shared\DataBase\Builder;
use Persistence\Shared\DataBase\Factory;
use Persistence\Shared\DataBase\Interfaces\DriverInterface;
use Persistence\Tasks\TaskRepository;
use Persistence\Users\UserRepository;

class ServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    
    public function provides(string $id): bool
    {
        $services = [
            DriverInterface::class,
            Builder::class,
            UserRepositoryInterface::class,
            UserRepository::class,
            TaskRepositoryInterface::class,
            TaskRepository::class,
            UploadRepositoryInterface::class,
            UploadRepository::class
        ];

        return in_array($id, $services);
    }

    /**
     * @throws Shared\DataBase\Exceptions\UnknownDatabaseDriverException
     */
    public function register(): void
    {
        $db = Factory::createDriver(App::config("config.database.default","mysql"));

        $this->getContainer()->add(DriverInterface::class,$db);

        $this->getContainer()->add(Builder::class)
                            ->addArgument(DriverInterface::class)
                            ->addArgument(App::config("config.database.default","mysql"));


        $this->getContainer()
            ->add(UserRepositoryInterface::class,UserRepository::class);

        $this->getContainer()
            ->add(TaskRepositoryInterface::class,TaskRepository::class);

        $this->getContainer()
            ->add(UploadRepositoryInterface::class,UploadRepository::class);
    }

    public function boot(): void
    {
        
    }

}