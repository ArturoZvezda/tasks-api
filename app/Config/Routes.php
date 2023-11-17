<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers','filter' => 'auth'], function ($routes) {
    $routes->post('task', 'TaskController::create');
});

$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
});
