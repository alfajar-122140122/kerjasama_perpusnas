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
});

// Admin routes (dengan prefix admin)
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');

    // Password management routes
    $routes->post('users/change-password/(:num)', 'Admin::changePassword/$1');
    $routes->post('users/reset-password/(:num)', 'Admin::resetPassword/$1');

    // User management routes
    $routes->post('users/add', 'Admin::addUser');
    $routes->post('users/edit/(:num)', 'Admin::editUser/$1');
    $routes->delete('users/delete/(:num)', 'Admin::deleteUser/$1');
    
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