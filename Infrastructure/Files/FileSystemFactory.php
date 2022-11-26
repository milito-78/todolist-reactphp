<?php
namespace Infrastructure\Files;

use Application\Interfaces\Infrastructure\Files\IFileSystem;
use Exception;
use Infrastructure\App;
use Infrastructure\Files\Exceptions\UnknownDriverException;

class FileSystemFactory{

    /**
     * create function
     *
     * @param string $driver
     * @return IFileSystem
     * @throws UnknownDriverException
     */
    public static function create(string $driver): IFileSystem{
        switch ($driver){
            case "local":
                return new FileSystem(App::container()->get((string)"filesystem"));
            default :
                throw new UnknownDriverException("Invalid driver type.");
        }
    }
}