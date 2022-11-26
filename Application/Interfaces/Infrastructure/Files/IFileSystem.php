<?php 
namespace Application\Interfaces\Infrastructure\Files;

use Psr\Http\Message\UploadedFileInterface;
use React\Promise\ExtendedPromiseInterface;

interface IFileSystem{

    /**
     * put function
     *
     * @param UploadedFileInterface $file
     * @param string $dir
     * @param string|null $name
     * @return ExtendedPromiseInterface
     */
    public function put(UploadedFileInterface $file, string $dir = "",?string $name = null) : ExtendedPromiseInterface;

    /**
     * move function
     *
     * @param string $path
     * @param string $target
     * @return ExtendedPromiseInterface
     */
    public function move(string $path, string $target): ExtendedPromiseInterface;

    /**
     * copy function
     *
     * @param string $path
     * @param string $target
     * @return void
     */
    public function copy(string $path, string $target):ExtendedPromiseInterface;

    /**
     * delete function
     *
     * @param string $paths
     * @return ExtendedPromiseInterface
     */
    public function delete(string $paths): ExtendedPromiseInterface;

    /**
     * get function
     *
     * @param string $path
     * @return ExtendedPromiseInterface
     */
    public function get(string $path): ExtendedPromiseInterface;

}