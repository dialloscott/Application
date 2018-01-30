<?php
/**
 * Application (https://github.com/dialloscott/learning_cours)
 * @link https://github.com/dialloscott/learning_cours
 * @copyright (c) 2018-01-01 Mamadou Lamine Diallo
 * @author Mamadou Lamine Diallo
 * @licence  https://github.com/dialloscott/learning_cours
 */

namespace Application;

use Application\http\{
    Request, Response
};
use Application\route\Route;
use Application\route\RouteCollection;

class Application
{
    public const VERSION = '0.0.1';

    /**
     * @var array
     */
    private static $version = [0, 0, 1];

    /**
     * @var Router
     */
    private $router;


    /**
     * Application constructor.
     */

    public function __construct()
    {
        $this->router = new Router(new RouteCollection());
    }

    /**
     * Retourne la version de l application
     * @return string
     */
    public static function version(): string
    {
        return @join('.', self::$version);
    }

    /**
     * Il  faut systematiquement un objet de type request
     * returen forcement un objet de type response
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request): Response
    {
        $response = new Response();
        $path = $request->getUri()->getPath();
        if ($path !== '/' && $path[-1] == '/') {
            return $response
                ->withHeader('Location', substr($path, 0, strlen($path) - 1));
        }
        if (isset($request->getParsedBody()['_method']) &&
            in_array($request->getParsedBody()['_method'], ['PUT', 'PATCH', 'DELETE'])) {
            $request = $request->withMethod($request->getParsedBody()['_method']);
        }
        try {
           $response =  $this->process($request, $response);
        }catch (\Exception $exception){
            $response = $response->withBody($exception->getMessage());
        }

        return $response;
    }

    /**
     * @param string $pattern
     * @param callable $callable |string
     * @return Route
     */
    public function get(string $pattern, $callable): Route
    {
        return $this->router->map('GET', $pattern, $callable);
    }

    /**
     * @param string $pattern
     * @param callable $callable
     * @return Route
     */
    public function post(string $pattern, callable $callable): Route
    {
        return $this->router->map('POST', $pattern, $callable);
    }

    /**
     * @param string $pattern
     * @param callable $callable
     * @return Route
     */
    public function put(string $pattern, callable $callable): Route
    {
        return $this->router->map('PUT', $pattern, $callable);
    }

    /**
     * @param string $pattern
     * @param callable $callable
     * @return Route
     */
    public function patch(string $pattern, callable $callable): Route
    {
        return $this->router->map('PATCH', $pattern, $callable);
    }

    /**
     * @param string $pattern
     * @param callable $callable
     * @return Route
     */
    public function delete(string $pattern, callable $callable): Route
    {
        return $this->router->map('DELETE', $pattern, $callable);
    }

    /**
     * @param string $pattern
     * @param callable $callable
     * @return Route
     */
    public function options(string $pattern, callable $callable): Route
    {
        return $this->router->map('OPTIONS', $pattern, $callable);
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    private function process(Request $request, Response $response)
    {
        $uri = trim($request->getUri()->getPath(), '/');
        $httpMethod = $request->getMethod();
        $routeResult = $this->router->match($uri, $httpMethod);
        if (!$routeResult->isMatched()) {
           throw new \Exception('The requested URL was not found on the server. If you entered the URL manually please check your spelling and try again');
        } else {
            $route = $routeResult->getMatched();
            $callable = $route->getCallable();
            $routeArgs = $route->getParameters();
            if (!empty($routeArgs)) {
                $request = array_reduce(array_keys($routeArgs), function ($carry, $item) use ($request, $routeArgs) {
                    return $request->withAttribute($item, $routeArgs[$item]);
                });
            }
            if (is_callable($callable)) {
                $callableReturn = call_user_func_array($callable, [$request] + $routeArgs);
            } else {
                $callableReturn = '';
                [$controller, $action] = explode('#', $callable);
                $reflection = new \ReflectionClass($controller);
                if ($reflection->isInstantiable()) {
                    $callableReturn = $reflection->newInstance();
                }
                $callableReturn = call_user_func_array([$callableReturn, $action], [$request] + $routeArgs);
            }
            if ($callableReturn instanceof Response) {
                $response = $callableReturn;
            } else {
                $response = $response->withBody($callableReturn);
            }
            return $response;
        }

    }
}