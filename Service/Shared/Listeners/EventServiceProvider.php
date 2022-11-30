<?php
namespace Service\Shared\Listeners;

use Infrastructure\DI\DependencyParamException;
use Infrastructure\DI\DependencyResolver;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Service\App;

class EventServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected array $server_events = [
        "error"                     => ErrorHandlerEvent::class,
        "upload_clean"              => UploadCleanerEvent::class,
        "delete_file"               => DeleteFileEvent::class,
        "send_verify_code_email"    => SendEmailVerificationCodeEvent::class,
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
        
    }


    /**
     * @throws DependencyParamException
     */
    private function setServerEvents()
    {
        $server = App::container()->get("HttpServer");
        $di = new DependencyResolver(App::container());

        foreach ($this->server_events as $event => $handler)
        {
            $server->on($event,$di->make($handler));
        }
    }

    /**
     * @throws DependencyParamException
     */
    private function setEvents()
    {
        $socket = App::container()->get("SocketSystem");
        $di = new DependencyResolver(App::container());

        foreach ($this->events as $event => $handler)
        {
            $socket->on($event,$di->make($handler));
        }
    }
	/**
	 * Method will be invoked on registration of a service provider implementing
	 * this interface. Provides ability for eager loading of Service Providers.
	 * @return void
	 */
	public function boot(): void {
        $this->setServerEvents();
        $this->setEvents();
	}
}