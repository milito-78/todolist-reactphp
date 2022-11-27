<?php 
namespace Infrastructure\Files;

use Application\Interfaces\Infrastructure\Files\IFileSystem;
use BadMethodCallException;
use React\Promise\ExtendedPromiseInterface;
use Psr\Http\Message\UploadedFileInterface;
/**
 * Storage class
 * @method static IFileSystem driver(?string $driver)
 * @method static ExtendedPromiseInterface put(UploadedFileInterface $file, string $dir = "",?string $name = null)
 * @method static ExtendedPromiseInterface move(string $path, string $target)
 * @method static ExtendedPromiseInterface copy(string $path, string $target)
 * @method static ExtendedPromiseInterface delete(string $paths)
 * @method static ExtendedPromiseInterface get(string $path)
 * 
 * @see FileSystemManager
 */
class Storage{
    static private ?FileSystemManager $filesystem = null;

    public static function __callStatic($name, $arguments)
    {
        $static = self::getOrCreateFacade();
        if (method_exists($static,$name)){
            return $static->{$name}(...$arguments);
        }
        throw new BadMethodCallException("Method not exists in Cache class");
    }

    public static function getOrCreateFacade(): FileSystemManager
    {
        if (!self::$filesystem)
            return self::$filesystem = new FileSystemManager();
        return self::$filesystem;
    }
}