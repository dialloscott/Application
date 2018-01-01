<?php
namespace Application\http;

class Uri
{
    /**
     * @var  string
     */
    public $scheme = '';

    /**
     * @var  string
     */
    public $host = '';
    /**
     * @var  int
     */
    public $port;
    /**
     * @var  string
     */
    public $user = '';
    /**
     * @var  int
     */
    public $pass = '';
    /**
     * @var  string
     */
    public $path = '/';
    
    /**
     * @var  string
     */
    public $query = '';
    /**
     * @var  string
     */
    public $fragment = '';


    public function __construct(string $uri = '')
    {
        if($uri !== ''){
            $parts = parse_url($uri);
            if($parts === false){
                throw new \Exception('Invalid argument, the argument most be a valid url');
            }
            $this->scheme = isset($parts['scheme']) ? $parts['scheme'] : '';
            $this->host = isset($parts['host']) ? $parts['host'] : '';
            $this->port = isset($parts['port']) ? $parts['port'] : '';
            $this->user = isset($parts['user']) ? $parts['user'] : '';
            $this->pass = isset($parts['pass']) ? $parts['pass'] : '';
            $this->path = isset($parts['path']) ? $parts['path'] : '';
            $this->query = isset($parts['query']) ? $parts['query'] : '';
            $this->fragment = isset($parts['fragment']) ? $parts['fragment'] : '';

        }
    }

    public static function fromGlobals():self
    {
        $uri = new self('');
        $uri->scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
        $uri->host =  $_SERVER['SERVER_NAME'];
        $uri->port = $_SERVER['SERVER_PORT'];
        $uri->path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/'): trim(explode('?', $_SERVER['REQUEST_URI'],2)[0],'/');
        $uri->query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        return $uri;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getFragment(): string
    {
        return $this->fragment;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
}