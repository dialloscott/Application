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

    public function __construct()
    {
        $this->router = new Router();
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
     * @return Respoonse $request
     *
     */
    public function handleRequest(Request $request): Response
    {
        $path = $request->getUri()->getPath();
        if ($path !== '/' && $path[-1] == '/') {
            return (new Response(301))
                ->withHeader('Location', substr($path, 0, strlen($path)));
        }
        switch ($path) {
            case 'users':

        }

    }

    /**
     * @param string $pattern
     * @param callable $callable
     * @return Route
     */
    public function get(string $pattern, callable $callable): Route
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
}