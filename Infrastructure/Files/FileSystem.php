<?php 
namespace Infrastructure\Files;

use Application\Interfaces\Infrastructure\Files\IFileSystem;
use Infrastructure\Files\Entities\File;
use Psr\Http\Message\UploadedFileInterface;
use React\Promise\ExtendedPromiseInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use React\Filesystem\AdapterInterface;

use function React\Promise\reject;
use function React\Promise\resolve;

class FileSystem implements IFileSystem{
    const UPLOADS_DIR               = "storage/public";
    protected string $projectRoot   = __ROOT__;

    private AdapterInterface $filesystem;

    public function __construct(AdapterInterface $filesystem)
    {
        $this->filesystem = $filesystem;
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
        $name       = $this->makeFileName($file,$name);
        $uploadPath = $this->projectRoot . '/' . $this->makeFilePath($dir);

        if (!is_dir($uploadPath)) 
            mkdir($uploadPath);
        

        $fullPath =  $uploadPath . $name;

        $content = (string)$file->getStream();
        file_put_contents($fullPath,$content);

        return resolve($name);    
    }

    /**
     * move function
     *
     * @param string $path
     * @param string $target
     * @return ExtendedPromiseInterface
     */
    public function move(string $path, string $target): ExtendedPromiseInterface{
        return rename($path, $target) ? resolve(true) : reject(false);
    }

    /**
     * copy function
     *
     * @param string $path
     * @param string $target
     * @return void
     */
    public function copy(string $path, string $target):ExtendedPromiseInterface{
        return copy($path, $target) ? resolve(true) : reject(false);
    }

    /**
     * delete function
     *
     * @param string $paths
     * @return ExtendedPromiseInterface
     */
    public function delete(string $paths): ExtendedPromiseInterface{
        $fullPath = $this->projectRoot . '/' . $paths;

        if(file_exists($fullPath))
        {
            unlink($fullPath);
            return resolve(true);
        }
        
        return reject(false);
    }

    /**
     * get function
     *
     * @param string $path
     * @return ExtendedPromiseInterface
     */
    public function get(string $path): ExtendedPromiseInterface{
        $file = $this->filesystem->file($this->projectRoot . $path);

        if(!file_exists($file->path() . $file->name()))
            return reject(new FileNotFoundException());

        $mimeType = mime_content_type($file->path() . $file->name());
        $contents = file_get_contents($file->path() . $file->name());

        return resolve(new File($contents,$mimeType));
    }


    protected function makeFilePath(string $name): string
    {
        return implode(
            '',
            [
                self::UPLOADS_DIR,
                '/',
                $name,
            ]
        );
    }

    private function makeFileName(UploadedFileInterface $file,?string $name = null) :string
    {
        preg_match('/^.*\.(.+)$/', $file->getClientFilename(), $filenameParsed);
        if(!$name)
            $name = md5(uniqid(rand(), true));

        return implode(
            '',
            [
                $name,
                '.',
                $filenameParsed[1],
            ]
        );
    }
}