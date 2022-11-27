<?php
namespace Service\Files\UploadFile;

use Application\Files\Commands\Upload\IUploadCommand;
use Domain\Files\Upload;
use Service\Shared\Helpers\Helpers;
use Service\Shared\Request\Controller;
use Service\Shared\Request\Request;

class UploadFileController extends Controller{
    public function __construct(private IUploadCommand $command)
    {
    }

    public function __invoke(Request $request)
    {
        $validated = $this->validate($request);
        return $this->command
                    ->Execute($validated->image())
                    ->then(function(Upload $upload){
                        return Helpers::response([
                            "message" => "File uploaded successfully",
                            "data" => [
                                "file" => [
                                    "id"            => $upload->id,
                                    "file_name"     => $upload->image_name,
                                    "file_path"     => $upload->image_path,
                                ]
                            ]
                        ]);
                    });
    }

    private function validate(Request $request): UploadFileRequest{
        $model = new UploadFileRequest($request);
        return $model->validate();
    }
}