<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/json/show/', 'SiswaController@jsonShow');
$router->post('/json/create/', 'SiswaController@jsonCreate');
$router->put('/json/edit/{nim}', 'SiswaController@jsonEdit');

$router->get('/xml/show/', 'SiswaController@xmlInfo');

$router->get('/yaml/show/', 'SiswaController@yamlInfo');