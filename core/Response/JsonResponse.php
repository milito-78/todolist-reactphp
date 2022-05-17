<?php
namespace Core\Response;

use Core\Exceptions\Model\ErrorModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\StreamInterface;
use React\Http\Io\HttpBodyStream;
use React\Stream\ReadableStreamInterface;
use RingCentral\Psr7\Response as Psr7Response;
use React\Http\Message\Response;
use function is_string;

final class JsonResponse extends Psr7Response implements StatusCodeInterface
{
    public function __construct(
        $status = 200,
        $data = '',
        $headers = null
    )
    {
        if (is_array($data)){
            $data = json_encode($data);
        }else {
            $data = $data ? json_encode($data) : null;
        }

        if ($status != 204)
        {
            if ($data instanceof ReadableStreamInterface && !$data instanceof StreamInterface)
            {
                $data = new HttpBodyStream($data, null);
            }
            elseif (!is_string($data) && !($data instanceof StreamInterface))
            {
                throw new \InvalidArgumentException('Invalid response body given');
            }
        }
        else
        {
            $data = null;
        }

        $header = [];

        if ( is_array($headers))
            $header = array_merge($header,$headers);

        parent::__construct(
            $status,
            $header,
            $data
        );
    }

    public static function ok($data) : self
    {
        return new self(200,$data);
    }

    public static function noContent() : self
    {
        return new self(204,null);
    }

    public static function created($data) : self
    {
        return new self(201,$data);
    }

    public static function notFound($message = "Route/Data not found!") : self
    {
        $title = "Not Found!";
        return new self(404, ErrorModel::error($title,$message));
    }

    public static function methodNotAllowed($message = "not allowed") : self
    {
        $title = "Method Not Allowed!";
        return new self(405, ErrorModel::error($title,$message));
    }

    public static function unAuthorized($message) : self
    {
        $title = "Unauthorized!";
        return new self(401,ErrorModel::error($title,$message));
    }

    public static function Aborted($message) : self
    {
        $title = "Forbidden error!";
        return new self(403,ErrorModel::error($title,$message));
    }

    public static function internalServerError(string $reason) : self
    {
        $title = "Server Error!";
        return  new self(500, ErrorModel::error($title,$reason) );
    }

    public static function validationError($reason) : self
    {
        $title = "Validation Failed!";

        return  new self(422, ErrorModel::error($title, $reason) );
    }

    public static function send($data = null, $code = 200, $headers = []) : self
    {
        return  new self($code, $data ,$headers);
    }

}