<?php
use Illuminate\Support\Facades\Route;


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api/v1'
], function ($router) {
	$router->group(['prefix' => 'comments'], function ($router) {
		$router->get('/list', 'Api\CommentController@index');
		$router->post('/store', 'Api\CommentController@store');
	});
});