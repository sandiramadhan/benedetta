<?php

require_once __DIR__ . './../system/routes.php';

$routes = new Routes();

$routes->group('/', ['middleware' => 'auth'], function($routes) {
	$routes->get('/', 'main::index');
	$routes->get('/contact/:id', 'main::contact');
});

$routes->group('/profile', ['middleware' => 'auth'], function($routes) {
	$routes->get('/', 'profile::index');
	$routes->get('/detail', 'profile::detail');
});

$routes->get('/login');

$routes->run();