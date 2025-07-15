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
    $routes->get('aktivitas', 'Public\BeritaController::index'); // Using BeritaController to handle aktivitas
    $routes->get('aktivitas/detail/(:num)', 'Public\BeritaController::detail/$1');
    
    // Berita routes (alternative URL for the same content)
    $routes->get('berita', 'Public\BeritaController::index');
    $routes->get('berita/detail/(:num)', 'Public\BeritaController::detail/$1');

    // Kerja Sama routes - gunakan controller baru
    $routes->get('kerja-sama', 'Public\KerjaSama::index');
    $routes->get('kerja-sama/data', 'Public\KerjaSamaController::data');
    $routes->get('kerja-sama/implementasi', 'Public\KerjaSamaController::implementasi');
    $routes->get('kerja-sama/akan-berakhir', 'Public\KerjaSamaController::akanBerakhir');
    $routes->get('kerja-sama/progress', 'Public\KerjaSamaController::progress');
    $routes->get('kerja-sama/pengajuan', 'Public\PermohonanController::index');
    $routes->post('kerja-sama/pengajuan/submit', 'Public\PermohonanController::submit');

    $routes->get('peta-kerja-sama', 'Public\KerjaSamaController::petaKerjasama');
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
    
    // Settings routes
    $routes->get('settings', 'Admin\UserController::settings');
    $routes->post('settings/update-profile', 'Admin\UserController::updateProfile');
    $routes->post('settings/update-password', 'Admin\UserController::updatePassword');
    
    // Admin Kerjasama Routes
    $routes->get('kerjasama/data', 'Admin\KerjasamaController::data');
    $routes->get('kerjasama/get/(:num)', 'Admin\KerjasamaController::get/$1');

    $routes->get('kerjasama/implementasi', 'Admin\KerjasamaController::implementasi');
    $routes->get('kerjasama/implementasi/tambah', 'Admin\KerjasamaController::tambahImplementasi');
    $routes->get('kerjasama/implementasi/edit/(:num)', 'Admin\KerjasamaController::editImplementasi/$1');
    $routes->post('kerjasama/implementasi/store', 'Admin\KerjasamaController::storeImplementasi');
    $routes->post('kerjasama/implementasi/update/(:num)', 'Admin\KerjasamaController::updateImplementasi/$1');
    $routes->delete('kerjasama/implementasi/delete/(:num)', 'Admin\KerjasamaController::deleteImplementasi/$1');
    $routes->get('kerjasama/implementasi/get/(:num)', 'Admin\KerjasamaController::getImplementasi/$1');

    $routes->get('kerjasama/akan-berakhir', 'Admin\KerjasamaController::akanBerakhir');

    // Progress Kerjasama Routes
    $routes->group('kerjasama/progress', function($routes) {
        $routes->get('', 'Admin\ProgressKerjasamaController::index');
        $routes->post('store', 'Admin\ProgressKerjasamaController::store');
        $routes->post('update/(:num)', 'Admin\ProgressKerjasamaController::update/$1');
        $routes->delete('delete/(:num)', 'Admin\ProgressKerjasamaController::delete/$1');
        $routes->post('delete/(:num)', 'Admin\ProgressKerjasamaController::delete/$1'); // Fallback for browsers that don't support DELETE
        $routes->get('get/(:num)', 'Admin\ProgressKerjasamaController::getProgress/$1');
    });

    $routes->get('kerjasama/pengajuan', 'Admin\KerjasamaController::pengajuan');

    // Admin Permohonan Routes
    $routes->get('permohonan', 'Admin\PermohonanController::index');
    $routes->get('permohonan/pending', 'Admin\PermohonanController::pending');
    $routes->get('permohonan/review', 'Admin\PermohonanController::review');
    $routes->get('permohonan/approved', 'Admin\PermohonanController::approved');
    $routes->get('permohonan/rejected', 'Admin\PermohonanController::rejected');
    $routes->get('permohonan/view/(:num)', 'Admin\PermohonanController::view/$1');
    $routes->post('permohonan/update-status', 'Admin\PermohonanController::updateStatus');
    $routes->post('permohonan/delete', 'Admin\PermohonanController::delete');

    $routes->get('kerjasama/tambah', 'Admin\KerjasamaController::tambah');
    $routes->get('kerjasama/edit/(:num)', 'Admin\KerjasamaController::edit/$1');
    $routes->post('kerjasama/store', 'Admin\KerjasamaController::store');
    $routes->post('kerjasama/update/(:num)', 'Admin\KerjasamaController::update/$1');
    $routes->delete('kerjasama/delete/(:num)', 'Admin\KerjasamaController::delete/$1');
    
    // Berita management routes
    $routes->get('berita', 'Admin\Berita::index');
    $routes->get('berita/get/(:num)', 'Admin\Berita::get/$1');
    $routes->post('berita/add', 'Admin\Berita::create');
    $routes->post('berita/update/(:num)', 'Admin\Berita::update/$1');
    $routes->delete('berita/delete/(:num)', 'Admin\Berita::delete/$1');
    $routes->post('berita/delete/(:num)', 'Admin\Berita::delete/$1'); // Fallback for browsers that don't support DELETE
    $routes->post('berita/status/(:num)', 'Admin\Berita::changeStatus/$1');

    // Settings routes
    $routes->get('pengaturan', 'Admin\Settings::index');
    $routes->post('pengaturan/update-profile', 'Admin\Settings::updateProfile');
    $routes->post('pengaturan/change-password', 'Admin\Settings::changePassword');
});

// Redirect dashboard ke admin dashboard untuk backward compatibility
$routes->get('dashboard', 'Admin\Dashboard::dashboard');