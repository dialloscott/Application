<?php

namespace Application\route;

class Route
{
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var callable
     */
    private $callable;

    public function __construct(string $method, string $pattern, callable $callable)
  {
      $this->method = $method;
      $this->pattern = $pattern;
      $this->callable = $callable;
  }
}