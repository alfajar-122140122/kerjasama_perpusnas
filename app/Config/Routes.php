<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page
$routes->get('/', 'Home::index');

// Auth routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
    $routes->post('check-password-strength', 'Auth::checkPasswordStrength');
});

// Admin routes (dengan prefix admin)
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    
    // User management routes
    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');  
    $routes->post('users/delete/(:num)', 'UserController::delete/$1');
    $routes->post('users/generate-password', 'UserController::generatePassword');
    
    // Tambahan routes untuk menu lain
    $routes->get('kerjasama', 'Admin::kerjasama');
    $routes->get('berita', 'Admin::berita');

    // Settings routes
    $routes->get('pengaturan', 'Settings::index');
    $routes->post('pengaturan/update-profile', 'Settings::updateProfile');
    $routes->post('pengaturan/change-password', 'Settings::changePassword');
});


// Redirect dashboard ke admin dashboard untuk backward compatibility
$routes->get('dashboard', 'Admin::dashboard');

// Landing page routes
$routes->get('tentang', 'Home::tentang');
$routes->get('aktivitas', 'Home::aktivitas');
$routes->get('kerja-sama', 'Home::kerjaSama');
$routes->get('peta-kerja-sama', 'Home::petaKerjaSama');
$routes->get('kontak', 'Home::kontak');