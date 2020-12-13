<?php

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
    return "www ".$router->app->version();
});

$router->get('user/{id}/{name}', function ($id, $name) {
    return 'User '.$id." - ".$name;
});


$router->group(['middleware'=> 'cors'], function($router) {
	$router->group(['middleware'=> 'so'], function($router) {
		$router->post('login', 'AuthController@postLogin');
		// Below is testing...
		$router->get('ListMenuXXX', 'AuthController@LoadListUserMenuXXX');
	});
});

$router->group(['middleware'=> ['cors','auth']], function($router) {	
	$router->group(['middleware'=> 'so'], function($router) {
		$router->get('ListMenu', 'AuthController@LoadListUserMenu');
		$router->get('GetForm', 'soLink@getLink');
		$router->post('PostForm', 'soLink@getLink');
		// Below is testing...
		$router->get('testToken', 'AuthController@test');
		$router->get('userLogin', 'AuthController@getUserLogin');
		$router->get('testGrid', 'AuthController@grid');
	});
});

// $router->get('/coba', 'ExampleController@cobacoba');
