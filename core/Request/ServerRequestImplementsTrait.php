<?php


namespace Core\Request;


use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

trait ServerRequestImplementsTrait
{
    public function getServerParams()
    {
        return $this->request->serverParams;
    }

    public function getCookieParams()
    {
        return $this->request->cookies;
    }

    public function withCookieParams(array $cookies)
    {
        return $this->request->withCookieParams($cookies);
    }

    public function getQueryParams()
    {
        return $this->request->getQueryParams();
    }

    public function withQueryParams(array $query)
    {
        return $this->request->withQueryParams($query);
    }

    public function getUploadedFiles()
    {
        return $this->request->getUploadedFiles();
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        return $this->request->withUploadedFiles($uploadedFiles);
    }

    public function getParsedBody()
    {
        return $this->request->getParsedBody();
    }

    public function withParsedBody($data)
    {
        return $this->request->withParsedBody($data);
    }

    public function getAttributes()
    {
        return $this->request->getAttributes();
    }

    public function getAttribute($name, $default = null)
    {
        return $this->request->getAttribute($name,$default);
    }

    public function withAttribute($name, $value)
    {
        return $this->request->withAttribute($name,$value);
    }

    public function withoutAttribute($name)
    {
        return $this->request->withoutAttribute($name);
    }

    /**
     * @param string $cookie
     * @return array
     */
    private function parseCookie($cookie)
    {
        return $this->request->parseCookie($cookie);
    }

    public function getProtocolVersion()
    {
        return $this->request->getProtocolVersion();
    }

    public function withProtocolVersion($version)
    {
        return $this->request->withProtocolVersion($version);
    }

    public function getHeaders()
    {
        return $this->request->getHeaders();
    }

    public function hasHeader($name)
    {
        return $this->request->hasHeader($name);
    }

    public function getHeader($name)
    {
        return $this->request->getHeader($name);
    }

    public function getHeaderLine($name)
    {
        return $this->request->getHeaderLine($name);
    }

    public function withHeader($name, $value)
    {
        return $this->request->withHeader($name,$value);
    }

    public function withAddedHeader($name, $value)
    {
        return $this->request->withAddedHeader($name,$value);
    }

    public function withoutHeader($name)
    {
        return $this->request->withoutHeader($name);
    }

    public function getBody()
    {
        return $this->request->getBody();
    }

    public function withBody(StreamInterface $body)
    {
        return $this->request->withBody($body);
    }

    public function getRequestTarget()
    {
        return $this->request->getRequestTarget();
    }

    public function withRequestTarget($requestTarget)
    {
        return $this->request->withRequestTarget($requestTarget);
    }

    public function getMethod()
    {
        return $this->request->getMethod();
    }

    public function withMethod($method)
    {
        return $this->request->withMethod($method);
    }

    public function getUri()
    {
        return $this->request->getUri();
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        return $this->request->withUri($uri,$preserveHost);
    }
}