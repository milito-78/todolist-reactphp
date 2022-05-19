<?php
namespace App\Domain\Inputs;

use Core\Request\Request;
use Respect\Validation\Validator;

class TaskUpdateInput{
    private Request $request;
    private bool $is_validated = false;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate()
    {
        $titleValidator = Validator::key(
            'title',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('title');
    
        $descriptionValidator = Validator::key(
            'description',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType(),
            )
        )->setName('description');

        $deadlineValidator = Validator::key(
            'deadline',
            Validator::allOf(
                Validator::nullable(Validator::dateTime()),
            )
        )->setName('deadline');

        $imageValidator = Validator::key(
            'image',
            Validator::allOf(
                Validator::optional(Validator::stringType()),
            )
        )->setName('image');

        Validator::allOf($titleValidator,$descriptionValidator, $deadlineValidator, $imageValidator)->assert($this->request->all());
        $this->is_validated = true;
    }


    public function validated() : array
    {
        if(!$this->is_validated)
            $this->validate();
        
        return [
            "title"       => $this->request->title,
            "description" => $this->request->description,
            "deadline"    => $this->request->deadline,
            "image_path"  => $this->request->image,
        ];
    }

    public function title() : string
    {
        return $this->request->title;
    }

    public function description() : string
    {
        return $this->request->description;
    }

    public function deadline(): ?string
    {
        return $this->request->deadline;
    }

    public function image(): ?string
    {
        return $this->request->image;
    }

    public function request(): Request
    {
        return $this->request;
    }
}