<?php


namespace App\UseCase;


use App\Domain\Inputs\UploadInput;

interface UploadImageUseCaseInterface
{
    public function handle(UploadInput $input);
}