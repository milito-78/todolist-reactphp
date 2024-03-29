<?php

namespace App\Core\Controller;

use App\Domain\Inputs\UploadInput;
use App\UseCase\UploadImageUseCaseInterface;
use Core\Request\Controller;
use Core\Request\Request;

class ImageUploadController extends Controller
{
    private UploadImageUseCaseInterface $uploadImageUseCase;
    
    public function __construct(UploadImageUseCaseInterface $uploadImageUseCase)
    {
        $this->uploadImageUseCase   = $uploadImageUseCase;
    }

    public function __invoke(Request $request)
    {
        $input = new UploadInput($request);
        return $this->uploadImageUseCase->handle($input);
    }


}