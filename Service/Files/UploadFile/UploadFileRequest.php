<?php 
namespace Service\Files\UploadFile;

use Psr\Http\Message\UploadedFileInterface;
use Respect\Validation\Validator;
use Service\Shared\Exceptions\ValidationException;
use Service\Shared\Request\Request;

class UploadFileRequest{

    private Request $request;
    private bool $is_validated = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate():self
    {
         /*
          *
          * // I don't know why respect\validation doesn't work this time :/
         $imageValidator = Validator::key(
            'image',
            Validator::anyOf(
                Validator::mimetype("image/jpg"),
                Validator::mimetype("image/jpeg"),
                Validator::mimetype("image/png"),
            )
        )->setName('image');

        Validator::allOf($imageValidator)->assert(["image" => $this->image()->getClientFilename()]);
        */

        if (!$image = $this->image())
            throw new ValidationException("image is required");

        $mime = $image->getClientMediaType();
        if (!in_array($mime,["image/jpg","image/jpeg","image/png"]))
            throw new ValidationException("image type is invalid");

        $this->is_validated = true;

        return $this;
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