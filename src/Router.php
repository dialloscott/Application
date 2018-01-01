<?php

namespace Application;


use Application\http\Request;
use Application\route\Route;

class Router
{


    private $routes;

    public function map(string $method, string $pattern, callable $callable): Route
    {
        $route = new  Route($method, $pattern, $callable);
        $this->routes[] = $route;
        return $route;
    }

    public function match(Request $request)
    {

    }
}