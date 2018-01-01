<?php

namespace Application\http;


class Request
{
    /**
     * la method de la requete
     * @var  string
     */
    public $method;

    /**
     * @var string| Uri
     */
    public $uri;

    /**
     * @var array
     */
    public $headers = [];

    /**
     * @var string
     */

    public $body = null;

    /**
     * @var string
     */
    public $protocolVersion = '1.1';

    /**
     * @var array
     */
    public $serverParams = [];
    /**
     * @var array
     */
    public $queryParams = [];
    /**
     * @var array
     */
    public $cookieParams = [];
    /**
     * @var array|object|null
     */
    public $parsedBody;
    /**
     * @var array
     */
    public $uploadedFiles = [];
    /**
     * @var array
     */
    public $attributes = [];

    /**
     * Request constructor.
     * @param string $method
     * @param Uri $uri
     * @param array $headers
     * @param string|null $body
     * @param string $protocolVersion
     * @param array $serverParams
     */
    public function __construct(string $method = 'GET', Uri $uri, array $headers = [], string $body = null, string $protocolVersion = '1.1', array $serverParams = [])
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->protocolVersion = $protocolVersion;
        $this->serverParams = $serverParams;
    }

    /**
     * @return  self
     */
    public static function fromGlobals(): self
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        $uri = Uri::fromGlobals();
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $protocolVersion = isset($_SERVER['SERVER_PROTOCOL']) ? substr($_SERVER['SERVER_PROTOCOL'], 5) : '1.1';
        $request = new Request($method, $uri, $headers, '', $protocolVersion, $_SERVER);
        return $request->withParsedBody($_POST)
            ->withCookieParams($_COOKIE)
            ->withQueryParams($_GET)
            ->withUploadedFiles($_FILES);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return Uri
     */
    public function getUri(): Uri
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    /**
     * @return array
     */
    public function getServerParams(): array
    {
        return $this->serverParams;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @return array
     */
    public function getCookieParams(): array
    {
        return $this->cookieParams;
    }

    /**
     * @return array|null|object
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    /**
     * @return array
     */
    public function getUploadedFiles(): array
    {
        return $this->uploadedFiles;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function withMethod(string $method): self
    {
        $clone = clone $this;
        $clone->method = strtoupper($method);
        return $clone;
    }

    public function withUri(Uri $uri): self
    {
        $clone = clone $this;
        $clone->uri = $uri;
        return $clone;
    }

    public function withBody(string $body): self
    {
        $clone = clone $this;
        $clone->body = $body;
        return $clone;
    }

    public function withCookieParams(array $cookies): self
    {
        $clone = clone $this;
        $clone->cookieParams = $cookies;
        return $clone;
    }

    public function withQueryParams(array $query): self
    {
        $clone = clone $this;
        $clone->queryParams = $query;
        return $clone;
    }

    public function withParsedBody(array $data): self
    {
        $clone = clone $this;
        $clone->parsedBody = $data;
        return $clone;
    }

    public function withUploadedFiles(array $files): self
    {
        $clone = clone $this;
        $clone->uploadedFiles = $files;
        return $clone;
    }

    public function withAttribute(string $name, $value): self
    {
        $clone = clone $this;
        $clone->attributes[$name] = $value;
        return $clone;
    }

    public function getAttribute(string $name, $default = false)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        return $default;
    }

    public function withServerParams(array $serverParams): self
    {
        $clone = clone $this;
        $clone->serverParams = $serverParams;
        return $clone;
    }


}