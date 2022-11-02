<?php

require_once __DIR__ . './../system/routes.php';

$routes = new Routes();

$routes->group('/', ['middleware' => 'auth'], function($routes) {
	$routes->get('/', 'main::index');
});

$routes->group('/profile', ['middleware' => 'auth'], function($routes) {
	$routes->get('/', 'profile::index');
});

$routes->get('/login');
// $routes->put('/');
// $routes->delete('/');

$routes->run();