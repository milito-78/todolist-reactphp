<?php 

namespace App\Domain\Inputs;

use Core\Request\Request;
use Psr\Http\Message\UploadedFileInterface;
use Respect\Validation\Validator;

class UploadInput{

    private Request $request;
    private bool $is_validated = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $imageValidator = Validator::key(
            'image',
            Validator::allOf(
                Validator::email(),
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('image');

        Validator::allOf($imageValidator)->assert($this->request->all());
        $this->is_validated = true;
    }


    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();
        
        return [
            "image"     => $this->image(),
        ];
    }

    public function image() : ?UploadedFileInterface
    {
        return $this->request->getUploadedFiles()["image"]??null;
    }
}