<?php

namespace App\Core\Controller;

use App\Core\Repositories\UploadRepositoryInterface;
use App\Domain\Inputs\UploadInput;
use Core\Request\Controller;
use Core\Request\Request;
use Psr\Http\Message\UploadedFileInterface;

class ImageUploadController extends Controller
{
    const UPLOADS_DIR = "/storage/public/images";
    private UploadRepositoryInterface $uploadRepository;
    
    public function __construct(UploadRepositoryInterface $uploadRepository)
    {
        $this->uploadRepository   = $uploadRepository;
    }

    public function __invoke(Request $request)
    {
        var_dump($request->getUploadedFiles());
        
        var_dump($this->makeFilePath($request->getUploadedFiles()["image"]));
        return "sqq";
        $input = new UploadInput($request);
        $input->validate();


    }

    private function makeFilePath(UploadedFileInterface $file): string
    {
        preg_match('/^.*\.(.+)$/', $file->getClientFilename(), $filenameParsed);

        var_dump($filenameParsed);
        return "sss";
    
        return implode(
            '',
            [
                self::UPLOADS_DIR,
                '/',
                md5((string)$file->getStream()),
                '.',
                $filenameParsed[1],
            ]
        );
    }
}