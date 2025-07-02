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
    
    // Kerjasama routes
    $routes->get('kerjasama', 'Kerjasama::index');
    $routes->get('kerjasama/dashboard', 'Kerjasama::dashboard');
    $routes->post('kerjasama/create', 'Kerjasama::create');
    $routes->post('kerjasama/update/(:num)', 'Kerjasama::update/$1');
    $routes->delete('kerjasama/delete/(:num)', 'Kerjasama::delete/$1');
    $routes->get('kerjasama/detail/(:num)', 'Kerjasama::detail/$1');
    $routes->get('kerjasama/export', 'Kerjasama::export');
    
    // Berita routes
    $routes->get('berita', 'Admin::berita');
    $routes->post('berita/add', 'Admin::addBerita');
    $routes->post('berita/edit/(:num)', 'Admin::editBerita/$1');
    $routes->delete('berita/delete/(:num)', 'Admin::deleteBerita/$1');

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