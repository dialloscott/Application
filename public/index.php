<?php

require('../vendor/autoload.php');

use Application\Application;
use Application\http\Request;

$app = new Application();
$app->delete('users/<int:id>', function (Request $request, $args) {
    return 'Tous les utilisateurs';
});
$app->put('users/<int:id>', function (Request $request) {
    return 'Tous les utilisateurs';
});
class Users
{
    public function show($req, $id){
        return 'Users id is '. $id;
    }
}
$app->get('users/<int:id>','Users#show')->setName('users.name');


$app->post('users/<int:id>', function (Request $request) {
    return 'Tous les utilisateurs';
});

$app->delete('users', function (Request $request) {
    return 'Tous les utilisateurs';
});
$app->get('users', function (Request $request) {
    return 'Tous les utilisateurs';
});
$app->get('users/<int:id>', function (Request $request, $name) {
    return 'Bonjour Mr.' . $name;
})->setName('users.name');

$request = Request::fromGlobals();

$response = $app->handleRequest($request);

if (php_sapi_name() === 'cli-server') {
    $response->send();
}
