<?php

namespace Application\http;

class Response
{
    /**
     * @var array
     */
    protected static $phrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];
    /**
     * @var int
     */
    public $statusCode = 200;

    /**
     * @var string
     */
    public $reasonPhrase = '';

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    public $body;
    /**
     * @var string
     */
    public $protocolVersion = '1.1';

    public function __construct(int $statusCode = 200, array $headers = [], string $body = '', string $protocolVersion = '1.1', string $reasonPhrase = '')
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
        $this->protocolVersion = $protocolVersion;
        if ($reasonPhrase === '' && isset(self::$phrases[$this->statusCode])) {
            $this->reasonPhrase = self::$phrases[$this->statusCode];
        } else {
            $this->reasonPhrase = $reasonPhrase;
        }
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return string
     */
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withStatusCode(int $status)
    {
        $clone = clone $this;
        $clone->statusCode = $status;
        return $clone;
    }

    /**
     * @param string $name
     * @param $value
     * @return Response
     */
    public function withHeader(string $name, $value): self
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;
        return $clone;
    }

    public function withBody(string $body): self
    {
        $clone = clone $this;
        $clone->body  .=  $body;
        return $clone;
    }

    /**
     * Envoie tous les headers et le contenu à afficher
     * @return void
     */
    public function send(): void
    {

        $httpLine = sprintf('HTTP/%s %s %s',
            $this->getProtocolVersion(),
            $this->getStatusCode(),
            $this->getReasonPhrase()
        );
        header($httpLine, true, $this->getStatusCode());
        foreach ($this->headers as $key => $value) {
            header("$key: $value", false);
        }
        echo $this->body;
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




}