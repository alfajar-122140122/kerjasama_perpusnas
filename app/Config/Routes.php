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
    
    // User management routes - MENGGUNAKAN USER CONTROLLER TERPISAH
    $routes->get('users', 'UserController::index'); // Halaman users
    $routes->get('users/data', 'UserController::getData'); // Get users data (AJAX)
    $routes->post('users/create', 'UserController::create'); // Tambah user
    $routes->get('users/show/(:num)', 'UserController::show/$1'); // Detail user
    $routes->post('users/update/(:num)', 'UserController::update/$1'); // Update user
    $routes->delete('users/delete/(:num)', 'UserController::delete/$1'); // Delete user
    $routes->post('users/toggle-status/(:num)', 'UserController::toggleStatus/$1'); // Toggle status
    $routes->post('users/generate-password', 'UserController::generatePassword'); // Generate password
    $routes->post('users/check-username', 'UserController::checkUsername'); // Check username availability
    $routes->post('users/check-email', 'UserController::checkEmail'); // Check email availability
    
    // Kerjasama routes
    $routes->get('kerjasama', 'Kerjasama::index');
    $routes->get('kerjasama/dashboard', 'Kerjasama::dashboard');
    $routes->post('kerjasama/create', 'Kerjasama::create');
    $routes->post('kerjasama/update/(:num)', 'Kerjasama::update/$1');
    $routes->delete('kerjasama/delete/(:num)', 'Kerjasama::delete/$1');
    $routes->get('kerjasama/detail/(:num)', 'Kerjasama::detail/$1');
    $routes->get('kerjasama/export', 'Kerjasama::export');
    
    // Berita routes
    $routes->get('berita', 'Berita::index');
    $routes->post('berita/create', 'Berita::create');
    $routes->post('berita/update/(:num)', 'Berita::update/$1');
    $routes->delete('berita/delete/(:num)', 'Berita::delete/$1');
    $routes->get('berita/detail/(:num)', 'Berita::detail/$1');
    $routes->post('berita/toggle-status/(:num)', 'Berita::toggleStatus/$1');

    // Settings routes
    $routes->get('pengaturan', 'Settings::index');
    $routes->post('pengaturan/update-profile', 'Settings::updateProfile');
    $routes->post('pengaturan/change-password', 'Settings::changePassword');
});

// API routes untuk AJAX calls
$routes->group('api', function($routes){
    $routes->get('users/statistics', 'UserController::getStatistics');
    $routes->get('dashboard/stats', 'Admin::getDashboardStats');
});

// Redirect dashboard ke admin dashboard untuk backward compatibility
$routes->get('dashboard', 'Admin::dashboard');

// Landing page routes
$routes->get('tentang', 'Home::tentang');
$routes->get('aktivitas', 'Home::aktivitas');
$routes->get('kerja-sama', 'Home::kerjaSama');
$routes->get('peta-kerja-sama', 'Home::petaKerjaSama');
$routes->get('kontak', 'Home::kontak');