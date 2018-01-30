<?php

namespace Application;


use Application\route\Route;
use Application\route\RouteResult;
use Application\route\RouteCollection;

class Router
{
    public const FOUND = 1;
    public const NOT_FOUND = 0;
    public const NOT_ALLOWED = -1;
    private const ROUTE_REGEX_PATTERN = <<<'REGEX'
'\<([a-z]+)?:?([\w-_]+)?\>'
REGEX;

    private static $routeTypes = [
        'default' => '([\w]+)',
        'int' => '([\d]+)',
        'string' => '([\w-_]+)'
    ];

    /**
     * @var Route[]
     */
    private $routes;


    /**
     * Router constructor.
     * @param RouteCollection|null $routeCollection
     */
    public function __construct(?RouteCollection $routeCollection)
    {
        $this->routes = $routeCollection;

    }

    /**
     * @param string $method
     * @param string $pattern
     * @param callable $callable
     * @return Route
     */
    public function map(string $method, string $pattern, $callable): Route
    {
        $route = new  Route($method, $pattern, $callable);
        $this->routes->addRoute($route);
        return $route;
    }

    /**
     * @param string $httpPath
     * @param string $httpMethod
     * @return RouteResult
     */
    public function match(string $httpPath, string $httpMethod = 'GET')
    {
        $routeResults = [];
        foreach ($this->routes as $route) {
            if (!in_array($route->getMethod(), [$httpMethod])) {
                continue;
            }
            $routePattern = preg_replace_callback(self::ROUTE_REGEX_PATTERN, function ($input) {
                return isset(self::$routeTypes[$input[1]]) ? self::$routeTypes[$input[1]] : self::$routeTypes['default'];
            }, $route->getPattern());
            $routePattern = '#^' . $routePattern . '$#i';
            if (!preg_match($routePattern, $httpPath, $matches)) {
                continue;
            }
            if (preg_match_all(self::ROUTE_REGEX_PATTERN, $route->getPattern(), $matchArgs)) {
                if (count($matchArgs[1]) !== count($matches) - 1) {
                    continue;
                }
                $arguments = [];
                foreach ($matchArgs[2] as $key => $value) {
                    if ($value === '') {
                        $arguments[$matchArgs[1][$key]] = $matches[$key + 1];
                    } else {
                        $arguments[$value] = $matches[$key + 1];
                    }
                }
                $route->setParameters($arguments);
            }
            $routeResults[] = [self::FOUND, $httpMethod, $route];
        }
        return new RouteResult($routeResults);
    }


}