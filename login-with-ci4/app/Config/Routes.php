<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('registration', 'Registration::index', ['as' => 'registration']);
$routes->post('registration/create', 'Registration::create');
$routes->get('dashboard', 'Admin::dashboard', ['as' => 'dashboard']);
