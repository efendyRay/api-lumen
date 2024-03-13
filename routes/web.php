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

$router->group(['prefix' => 'auth'], function() use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
});

$router->group(['prefix' => 'user', 'middleware' => ['role:admin|user']], function () use ($router) {
    $router->get('/index', 'UserController@index');
    $router->get('/detail/{id}', 'UserController@detail');
    $router->post('/store', 'UserController@store');
    $router->put('/update/{id}', 'UserController@update');
});

$router->group(['middleware' => 'role:admin'], function () use ($router) {
    $router->delete('user/delete/{id}', 'UserController@destroy');
    $router->delete('product/delete/{id}', 'ProductController@destroy');
});

$router->group(['prefix' => 'product', 'middleware' => ['role:admin|user']], function () use ($router) {
    $router->get('/index', 'ProductController@index');
    $router->get('/detail/{id}', 'ProductController@detail');
    $router->post('/store', 'ProductController@store');
    $router->put('/update/{id}', 'ProductController@update');
});