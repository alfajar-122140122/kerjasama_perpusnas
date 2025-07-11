<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->group('', function($routes) {
    // Landing page
    $routes->get('/', 'Public\Home::index');

    // Public routes
    $routes->get('tentang', 'Public\Home::tentang');
    $routes->get('aktivitas', 'Public\Home::aktivitas');
    $routes->get('aktivitas/detail/(:num)', 'Public\AktivitasController::detail/$1');

    // Kerja Sama routes - gunakan controller baru
    $routes->get('kerja-sama', 'Public\KerjaSama::index');
    $routes->get('kerja-sama/data', 'Public\KerjaSamaController::data');
    $routes->get('kerja-sama/implementasi', 'Public\KerjaSama::implementasi');
    $routes->get('kerja-sama/akan-berakhir', 'Public\KerjaSama::akanBerakhir');
    $routes->get('kerja-sama/progress', 'Public\KerjaSama::progress');
    $routes->get('kerja-sama/pengajuan', 'Public\KerjaSama::pengajuan');
    $routes->post('kerja-sama/pengajuan', 'Public\KerjaSama::submitPengajuan');

    $routes->get('peta-kerja-sama', 'Public\Home::petaKerjaSama');
    $routes->get('kontak', 'Public\Home::kontak');
});

// Auth routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth\Auth::login');
    $routes->post('login', 'Auth\Auth::attemptLogin');
    $routes->get('logout', 'Auth\Auth::logout');
});

// Admin routes (dengan prefix admin)
$routes->group('admin', function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::dashboard');
    
    // User Management Routes
    $routes->get('users', 'Admin\UserController::index');
    $routes->post('users/add', 'Admin\UserController::add');
    $routes->post('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');
    $routes->post('users/change-password/(:num)', 'Admin\UserController::changePassword/$1');
    $routes->post('users/reset-password/(:num)', 'Admin\UserController::resetPassword/$1');
    $routes->get('users/data/(:num)', 'Admin\UserController::getUserData/$1');
    
    // Admin Kerjasama Routes
    $routes->get('kerjasama/data', 'Admin\KerjasamaController::data');
    $routes->get('kerjasama/get/(:num)', 'Admin\KerjasamaController::get/$1');

    $routes->get('kerjasama/implementasi', 'Admin\KerjasamaController::implementasi');
    $routes->get('kerjasama/implementasi/tambah', 'Admin\KerjasamaController::tambahImplementasi');
    $routes->get('kerjasama/implementasi/edit/(:num)', 'Admin\KerjasamaController::editImplementasi/$1');

    $routes->get('kerjasama/akan-berakhir', 'Admin\KerjasamaController::akanBerakhir');

    $routes->get('kerjasama/progress', 'Admin\KerjasamaController::progress');

    $routes->get('kerjasama/pengajuan', 'Admin\KerjasamaController::pengajuan');

    $routes->get('kerjasama/tambah', 'Admin\KerjasamaController::tambah');
    $routes->get('kerjasama/edit/(:num)', 'Admin\KerjasamaController::edit/$1');
    $routes->post('kerjasama/store', 'Admin\KerjasamaController::store');
    $routes->post('kerjasama/update/(:num)', 'Admin\KerjasamaController::update/$1');
    $routes->delete('kerjasama/delete/(:num)', 'Admin\KerjasamaController::delete/$1');
    
    // Berita management routes
    $routes->get('berita', 'Admin\Berita::index');
    $routes->post('berita/add', 'Admin\Berita::create');
    $routes->post('berita/update/(:num)', 'Admin\Berita::update/$1');
    $routes->delete('berita/delete/(:num)', 'Admin\Berita::delete/$1');

    // Settings routes
    $routes->get('pengaturan', 'Admin\Settings::index');
    $routes->post('pengaturan/update-profile', 'Admin\Settings::updateProfile');
    $routes->post('pengaturan/change-password', 'Admin\Settings::changePassword');
});

// Redirect dashboard ke admin dashboard untuk backward compatibility
$routes->get('dashboard', 'Admin\Dashboard::dashboard');