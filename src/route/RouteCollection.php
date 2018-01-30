<?php

namespace Application\route;


class RouteCollection extends \SplObjectStorage
{

    public function addRoute(Route $route,array $data = [])
    {
        parent::attach($route, $data);
    }

    public function all()
    {
        $temp = [];
        foreach ($this as $route) {
            $temp[] = $route;
        }
        return $temp;
    }

}