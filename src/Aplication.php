<?php

namespace Application;

use Application\http\{
    Request, Response
};

class Application
{

    private static $version = [0, 0, 1];

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
        return new Response(301, [], '<h1>Salut le gens </h1>');
    }
}