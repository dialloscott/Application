<?php

namespace Application\route;


use Application\Router;

class RouteResult
{
    /**
     * @var array
     */
    private $routeResults;

    /**
     * RouteResult constructor.
     * @param array $routeResults
     */
    public function __construct(array $routeResults)
    {
        $this->routeResults = $routeResults;
    }

    public function isMatched():bool
    {
       return !empty($this->routeResults);
    }

    /**
     * @return Route|null
     */
    public function getMatched():?Route
    {
        $route = null;
        foreach ($this->routeResults as $routeResult) {
             if($routeResult[0] === Router::FOUND) {
                 $route = $routeResult[2];
             }
        }
        return $route;
    }
}