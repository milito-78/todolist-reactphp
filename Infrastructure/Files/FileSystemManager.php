<?php 
namespace Infrastructure\Files;

use Application\Interfaces\Infrastructure\Files\IFileSystem;
use Infrastructure\App;
use Infrastructure\Files\Exceptions\UnknownDriverException;
use Psr\Http\Message\UploadedFileInterface;
use React\Promise\ExtendedPromiseInterface;

class FileSystemManager {

    private array $drivers = [];

    /**
     * driver function
     *
     * @param string|null $driver
     * @return IFileSystem
     * @throws UnknownDriverException
     */
    public function driver(?string $driver = null) : IFileSystem {
        if(!$driver){
            $driver = App::config("config.filesystem.driver");
        }

        if(key_exists($driver,$this->drivers) && $this->drivers[$driver]){
            return $this->drivers[$driver];
        }else{
            return $this->drivers[$driver] = FileSystemFactory::create($driver);
        }
    }

    /**
     * put function
     *
     * @param UploadedFileInterface $file
     * @param string $dir
     * @param string|null $name
     * @return ExtendedPromiseInterface
     */
    public function put(UploadedFileInterface $file, string $dir = "",?string $name = null) : ExtendedPromiseInterface{
        return $this->driver()->put($file,$dir,$name);
    }

    /**
     * move function
     *
     * @param string $path
     * @param string $target
     * @return ExtendedPromiseInterface
     */
    public function move(string $path, string $target): ExtendedPromiseInterface{
        return $this->driver()->move( $path, $target);
    }

    /**
     * copy function
     *
     * @param string $path
     * @param string $target
     * @return ExtendedPromiseInterface
     */
    public function copy(string $path, string $target):ExtendedPromiseInterface{
        return $this->driver()->copy( $path, $target);
    }

    /**
     * delete function
     *
     * @param string $paths
     * @return ExtendedPromiseInterface
     */
    public function delete(string $paths): ExtendedPromiseInterface{
        return $this->driver()->delete($paths);
    }

    /**
     * get function
     *
     * @param string $path
     * @return ExtendedPromiseInterface
     */
    public function get(string $path): ExtendedPromiseInterface{
        return $this->driver()->get($path);
    }
}