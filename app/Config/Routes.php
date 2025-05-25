<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->post('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');



//admin dashboard
$routes->get('admin/dashboard', 'Admin::dashboard');