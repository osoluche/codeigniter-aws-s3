<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth routes
$routes->get('/', 'Home::login');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->post('auth/authenticate', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

// Protected routes group
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    
    // Admin routes
    $routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('users', 'UserController::index');
        $routes->get('users/create', 'UserController::create');
        $routes->post('users/create', 'UserController::create');
        $routes->get('users/edit/(:num)', 'UserController::edit/$1');
        $routes->post('users/update/(:num)', 'UserController::edit/$1');
        $routes->get('users/delete/(:num)', 'UserController::delete/$1');
        $routes->post('users/delete/(:num)', 'UserController::delete/$1');
    });
    
    // File management routes
    $routes->group('files', ['filter' => 'auth'], function($routes) {
        $routes->get('/', 'FileController::index');
        $routes->get('upload', 'FileController::uploadForm');
        $routes->post('upload', 'FileController::upload');
        $routes->get('download/(:num)', 'FileController::download/$1');
        $routes->get('delete/(:num)', 'FileController::delete/$1');
    });
});
