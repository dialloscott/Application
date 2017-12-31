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
    public $pass;
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
}