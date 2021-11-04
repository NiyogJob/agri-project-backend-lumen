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

$router->post('/cropfielditem/add', 'CropfieldController@add');
$router->post('/cropfielditem/edit', 'CropfieldController@edit');
$router->post('/cropfielditem/delete', 'CropfieldController@delete');
$router->get('/cropfielditem/get', 'CropfieldController@get');
$router->get('/cropfielditem/list', 'CropfieldController@list');
$router->get('/cropfielditem/search', 'CropfieldController@search');

$router->post('/tractors/add', 'TractorsController@add');
$router->post('/tractors/edit', 'TractorsController@edit');
$router->post('/tractors/delete', 'TractorsController@delete');
$router->get('/tractors/get', 'TractorsController@get');
$router->get('/tractors/list', 'TractorsController@list');
$router->get('/tractors/search', 'TractorsController@search');

$router->post('/processfield/add', 'ProcessFieldController@add');
$router->post('/processfield/delete', 'ProcessFieldController@delete');
$router->get('/processfield/get', 'ProcessFieldController@get');
$router->get('/processfield/list', 'ProcessFieldController@list');
