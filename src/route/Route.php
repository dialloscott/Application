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
    /**
     * @var string|null
     */
    private $name;

    private $parameters = [];

    public function __construct(string $method, string $pattern, $callable, ?string $name = null)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return callable|string
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = array_merge($this->parameters, $parameters);
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}