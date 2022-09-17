<?php
use Illuminate\Support\Facades\Route;


$router->get('/', function () use ($router) {
    return $router->app->version();
});

require('api.php');