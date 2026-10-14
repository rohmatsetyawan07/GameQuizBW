<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Halaman Pendaftaran (Form)
$routes->get('/', 'Home::index');

// Proses simpan data pendaftaran
$routes->post('home/save', 'Home::save');

// PERBAIKAN 1: Halaman Kuis (Disesuaikan menjadi 'kuis' agar cocok dengan redirect)
$routes->get('kuis', 'Home::siap');

// PERBAIKAN 2: Proses simpan skor (Disamakan dengan nama fungsi submit_skor di controller)
$routes->post('home/submit_skor', 'Home::submit_skor');

// PERBAIKAN 3: Halaman Leaderboard (Disesuaikan menjadi 'leaderboard' agar cocok dengan redirect)
$routes->get('leaderboard', 'Home::leaderboard');

// Halaman Panel Admin
$routes->get('admin', 'Home::admin');

// Proses reset session
$routes->get('home/reset', 'Home::reset');