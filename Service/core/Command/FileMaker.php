<?php


namespace Core\Command;

use JetBrains\PhpStorm\ArrayShape;

trait FileMaker
{
    protected array $types = [
        'model' => [
                    "base"      => "/app/Model/",
                    "namespace" => "App\Model",
                    "implement" => "App\Core\DataBase\Model",
                    "stub"      => "ModelStub.txt"
                    ],
        'controller' => [
                            "base"      => "/app/Http/Controller/",
                            "namespace" => "App\Http\Controller",
                            "implement" => "Core\Request\Controller",
                            "stub"      => "ControllerStub.txt"
                        ],
        'middleware' => [
                            "base"      => "/app/Http/Middleware/",
                            "namespace" => "App\Http\Middleware",
                            "implement" => "Core\Route\Middleware\Middleware",
                            "stub"      => "MiddlewareStub.txt"
                        ],
        'request' => [
                            "base"      => "/app/Http/Request/",
                            "namespace" => "App\Http\Request",
                            "implement" => "Core\Request\FormRequest",
                            "stub"      => "RequestStub.txt"
                        ]
        ];

    public function makeModel($name,$type)
    {
        $parser = $this->parseNameSpace($name);
        $name = $parser["name"];

        $path = $this->types[$type]["base"];

        if (count($parser["namespace"]))
        {
            foreach ($parser["namespace"] as $folder)
            {
                $path .= '/' . $folder;
                if (!is_dir(getcwd() . $path ))
                {
                    mkdir(getcwd() . $path);
                }
            }

        }
        else
        {

            if (!is_dir(getcwd() . $path ))
            {
                mkdir(getcwd() . $path);
            }
        }

        if (file_exists(getcwd() . $path . $name.'.php'))
        {
            throw new class extends \Exception{};
        }

        $path = $this->checkSlash($path);

        $file = fopen(getcwd() . $path . $name.'.php' ,"w") or die("Error");

        $stub = file_get_contents(getcwd() . '/Core/Stubs/' .$this->types[$type]["stub"]);

        $stub = $this->regexReplaceNameSpace($stub ,$type , $parser["namespace"]);
        $stub = $this->regexReplaceModelNameSpace($stub ,$type, $parser["namespace"]);
        $stub = $this->regexReplaceModelName($stub , $name);

        fwrite($file,$stub);

        fclose($file);
    }

    private function regexReplaceNameSpace($stub,$type,$namespaces): array|string|null
    {
        $temp = $this->types[$type]["namespace"];

        if (count($namespaces))
        {
            foreach ($namespaces as $namespace){
                $temp .= '\\' . $namespace;
            }
        }

        return preg_replace('/\{\{\s*namespace\s*\}\}/i',$temp,$stub);
    }

    private function regexReplaceModelNameSpace($stub , $type , $namespaces): array|string|null
    {
        $temp = "use {$this->types[$type]['implement']};";

        return preg_replace('/\{\{\s*model_namespace\s*\}\}/i',$temp,$stub);
    }

    private function regexReplaceModelName($stub,$name): array|string|null
    {
        return preg_replace('/\{\{\s*class_name\s*\}\}/i',$name,$stub);
    }

    #[ArrayShape(["namespace" => "string[]", "name" => "string"])]
    public function parseNameSpace($name): array
    {
        $temp = explode("\\" , $name);

        $file = $temp[count($temp) - 1];

        unset($temp[count($temp) - 1]);

        return ["namespace" => $temp , "name" => $file ];
    }

    private function checkSlash($path): mixed
    {
        if (strlen($path) == 0 || $path == '/') {
            return '/';
        }

        if (substr($path , 0,1) != '/')
            $path =  '/' . $path;

        if (substr($path,-1) != '/')
            $path .= '/';

        return $path;
    }
}