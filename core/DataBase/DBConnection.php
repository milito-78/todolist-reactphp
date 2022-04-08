<?php
namespace Core\DataBase;


use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use React\MySQL\Io\LazyConnection;

class DBConnection
{
    /**
     * @var LazyConnection
     */
    private static LazyConnection $instance;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct()
    {
        global $container;

        self::$instance = $container
                ->get(
                    id: (string) "database"
                )->createLazyConnection(
                    $this->getUri()
                );
    }

    public static function getInstance(): LazyConnection
    {
        if (is_null(self::$instance)) {
            new self();
        }
        return self::$instance;
    }

    #[Pure]
    private function getUri(): string
    {
        return  env("DB_USER") .
                ":" .
                env("DB_PASSWORD") .
                "@".
                env("DB_HOST") .
                "/".
                env("DB_NAME");
    }

}