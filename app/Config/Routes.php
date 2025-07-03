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
    
    // Tambahkan rute untuk getUsers di Admin\UserManagement
    $routes->get('users/api/get-users', 'Admin\UserManagement::getUsers');
    $routes->get('users/api/get-statistics', 'Admin\UserManagement::getUserStatistics');

    // Kerjasama routes - Put back inside admin group
    $routes->get('kerjasama', 'Kerjasama::index');
    $routes->get('kerjasama/dashboard', 'Kerjasama::dashboard');
    $routes->post('kerjasama/create', 'Kerjasama::create');
    $routes->post('kerjasama/update/(:num)', 'Kerjasama::update/$1');
    $routes->post('kerjasama/delete/(:num)', 'Kerjasama::delete/$1'); // Changed from DELETE to POST for better compatibility
    $routes->get('kerjasama/detail/(:num)', 'Kerjasama::detail/$1');
    $routes->get('kerjasama/export', 'Kerjasama::export');
    
    // Add routes for implementasi
    $routes->post('kerjasama/implementasi/create', 'Kerjasama::addImplementasi');
    $routes->get('kerjasama/implementasi/detail/(:num)', 'Kerjasama::implementasiDetail/$1');
    $routes->post('kerjasama/implementasi/update/(:num)', 'Kerjasama::updateImplementasi/$1');
    $routes->post('kerjasama/implementasi/delete/(:num)', 'Kerjasama::deleteImplementasi/$1');

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

    // User Management API routes
    $routes->get('users/api/get-users', 'Admin\UserManagement::getUsers');
    $routes->get('users/api/get-statistics', 'Admin\UserManagement::getUserStatistics');
});

// Redirect dashboard ke admin dashboard untuk backward compatibility
$routes->get('dashboard', 'Admin::dashboard');

// Landing page routes
$routes->get('tentang', 'Home::tentang');
$routes->get('aktivitas', 'Home::aktivitas');
$routes->get('kerja-sama', 'Home::kerjaSama');
$routes->get('peta-kerja-sama', 'Home::petaKerjaSama');
$routes->get('kontak', 'Home::kontak');

// Tambahkan route untuk admin/users
$routes->post('admin/users/create', 'UserController::create');
$routes->post('admin/users/generate-password', 'UserController::generatePassword');

// Lengkapi route untuk CRUD user management
$routes->get('admin/users/show/(:num)', 'UserController::show/$1');
$routes->post('admin/users/update/(:num)', 'UserController::update/$1');
$routes->delete('admin/users/delete/(:num)', 'UserController::delete/$1');
$routes->post('admin/users/toggle-status/(:num)', 'UserController::toggleStatus/$1');
$routes->get('admin/users/edit/(:num)', 'UserController::edit/$1');