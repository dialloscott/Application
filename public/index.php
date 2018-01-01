<?php

require('../vendor/autoload.php');

use Application\Application;
use Application\http\Request;

$app = new Application();
 $app->get('users',function(Request $request){
    return 'Tous les utilisateurs';
 });

$app->get('users/{name}',function(Request $request, $name){
    return 'Bonjour Mr.' . $name;
});
$request = Request::fromGlobals();

$response = $app->handleRequest($request);

if(php_sapi_name() === 'cli-server'){
    $response->send();
}
