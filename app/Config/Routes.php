<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
});

$routes->get('dashboard', 'Dashboard::index');

$routes->get('/berita', 'BeritaController::index');
$routes->get('/kerjasama', 'KerjasamaController::index');
$routes->get('/permohonan', 'PermohonanController::index');
$routes->get('/implementasi', 'ImplementasiController::index');
