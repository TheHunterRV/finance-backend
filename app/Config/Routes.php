<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->post('login', 'Auth::login');

$routes->post('records', 'Records::create');
$routes->get('records', 'Records::index');
$routes->put('records/(:num)', 'Records::update/$1');
$routes->delete('records/(:num)', 'Records::delete/$1');

$routes->get('dashboard', 'Dashboard::index');