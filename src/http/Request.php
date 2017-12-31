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

    public $body = '';

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
    public $attributes  = [];


}