<?php


namespace Core\Providers;


use App\Core\Events\ErrorHandlerEvent;
use Core\DI\DependencyResolver;
use League\Container\ServiceProvider\AbstractServiceProvider;

class EventServiceProvider extends AbstractServiceProvider
{
    protected array $server_events = [
        "error" => ErrorHandlerEvent::class
    ];

    protected array $events = [

    ];

    public function provides(string $id): bool
    {
        $services = [
        ];
        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->setServerEvents();
        $this->setEvents();
    }


    /**
     * @throws \Core\DI\DependencyParamException
     */
    private function setServerEvents()
    {
        global $server;
        $di = new DependencyResolver();

        foreach ($this->server_events as $event => $handler)
        {
            $server->on($event,$di->make($handler));
        }
    }

    /**
     * @throws \Core\DI\DependencyParamException
     */
    private function setEvents()
    {
        global $socket;
        $di = new DependencyResolver();

        foreach ($this->events as $event => $handler)
        {
            $socket->on($event,$di->make($handler));
        }
    }
}