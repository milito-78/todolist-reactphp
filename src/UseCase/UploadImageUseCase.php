<?php


namespace App\UseCase;


use App\Common\Files\Uploader;
use App\Core\Repositories\UploadRepositoryInterface;
use App\Domain\Entities\Upload;
use App\Domain\Inputs\UploadInput;
use App\Domain\Outputs\ImageUploadOutput;

class UploadImageUseCase implements UploadImageUseCaseInterface
{
    private Uploader $uploader;
    private UploadRepositoryInterface $uploadRepository;

    public function __construct(Uploader $uploader, UploadRepositoryInterface $uploadRepository)
    {
        $this->uploader         = $uploader;
        $this->uploadRepository = $uploadRepository;
    }

    public function handle(UploadInput $input)
    {
        return $this->uploader
            ->upload($input->image())
            ->then(function ($image_name){
                return $this->uploadRepository->create([
                    "image_name" => $image_name
                ]);
            })->then(function ($image){
                $output = new ImageUploadOutput(new Upload($image));
                return response($output->output());
            });
    }
}