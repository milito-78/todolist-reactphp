<?php


namespace Core\Providers;


use App\Core\Events\ErrorHandlerEvent;
use Core\DI\DependencyResolver;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CronJobServiceProvider extends AbstractServiceProvider
{
    protected array $jobs = [

    ];

    public function provides(string $id): bool
    {
        $services = [
        ];
        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->setCronJobs();
    }


    /**
     * @throws \Core\DI\DependencyParamException
     */
    private function setCronJobs()
    {
        $loop = loop();

        $di = new DependencyResolver();

        foreach ($this->jobs as $job => $seconds)
        {
            $loop->addPeriodicTimer($seconds,$di->make($job));
        }
    }

}