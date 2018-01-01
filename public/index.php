<?php

require('../vendor/autoload.php');
use Application\Application;
use Application\http\Request;

$app = new Application();

$request = Request::fromGlobals();

$response = $app->handleRequest($request);


$response->send();