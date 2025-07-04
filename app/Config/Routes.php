<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page
$routes->get('/', 'Public\Home::index');

// Public routes
$routes->get('tentang', 'Public\Home::tentang');
$routes->get('kontak', 'Public\Home::kontak');
$routes->get('aktivitas', 'Public\Home::aktivitas');

// Auth routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth\Auth::login');
    $routes->post('login', 'Auth\Auth::attemptLogin');
    $routes->get('logout', 'Auth\Auth::logout');
});

// Admin routes (dengan prefix admin)
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::dashboard');
    $routes->get('users', 'Admin\Dashboard::users');

    // Password management routes
    $routes->post('users/change-password/(:num)', 'Admin\Dashboard::changePassword/$1');
    $routes->post('users/reset-password/(:num)', 'Admin\Dashboard::resetPassword/$1');

    // User management routes
    $routes->post('users/add', 'Admin\Dashboard::addUser');
    $routes->post('users/edit/(:num)', 'Admin\Dashboard::editUser/$1');
    $routes->delete('users/delete/(:num)', 'Admin\Dashboard::deleteUser/$1');
    
    // Tambahan routes untuk menu lain
    $routes->get('kerjasama', 'Admin\Dashboard::kerjasama');
    $routes->get('berita', 'Admin\Dashboard::berita');

    // Settings routes
    $routes->get('pengaturan', 'Admin\Settings::index');
    $routes->post('pengaturan/update-profile', 'Admin\Settings::updateProfile');
    $routes->post('pengaturan/change-password', 'Admin\Settings::changePassword');
});


// Redirect dashboard ke admin dashboard untuk backward compatibility
$routes->get('dashboard', 'Admin\Dashboard::dashboard');

$routes->get('aktivitas', 'Public\Home::aktivitas');
$routes->get('kerja-sama', 'Public\Home::kerjaSama');
$routes->get('peta-kerja-sama', 'Public\Home::petaKerjaSama');