<?php

namespace Tests;

use Application\Application;
use Application\http\Request;
use Application\http\Response;
use Application\http\Uri;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testHandlerRequest()
    {
        $app = new Application();
        $uri = new Uri('https://localhost:8000/users');
        $request = new Request('GET', $uri);
        $response = $app->handleRequest($request);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testRedirectWithSlashAtLastToPath()
    {
        $app = new Application();
        $uri = new Uri('https://localhost:8000/users/');
        $request = new Request('GET', $uri);
        $response = $app->handleRequest($request);
        $this->assertArrayHasKey('Location', $response->getHeaders());
    }

}