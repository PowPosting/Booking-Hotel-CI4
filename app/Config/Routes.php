<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===== HOME & AUTH =====
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->post('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');
$routes->post('/forgot-password', 'Auth::forgotPassword');
$routes->get('/reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->post('/reset-password/update', 'Auth::updatePassword');
$routes->post('/check-username', 'Auth::checkUsername'); 

// ===== CART =====
$routes->group('cart', function($routes) {
    $routes->get('/', 'Cart::index');
    $routes->post('add', 'Cart::add');
    $routes->post('remove', 'Cart::remove');
    //$routes->post('update', 'Cart::update');
    $routes->get('count', 'Cart::count');
    $routes->get('getItems', 'Cart::getItems');
    $routes->post('clear', 'Cart::clear');
   // $routes->post('check-availability', 'Cart::checkAvailability');
});

// ===== BOOKING =====
$routes->group('booking', function($routes) {
    $routes->post('process', 'Booking::process');
    $routes->get('/', 'Booking::index');
    $routes->get('notifications', 'Booking::getNotifications');
    $routes->get('payment/(:num)', 'Booking::payment/$1');
});

// Booking routes
$routes->get('booking/success', 'Booking::success');
$routes->get('my-bookings', 'Booking::index');
$routes->get('/booking/history', 'Booking::history');
$routes->get('/booking/detail/(:num)', 'Booking::detail/$1');
$routes->post('/booking/cancel/(:num)', 'Booking::cancel/$1');

// Admin routes - dengan filter auth
$routes->group('admin', function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Booking management
    $routes->get('bookings', 'Admin::bookings'); // **TAMBAH method untuk handle GET**
    $routes->post('bookings/update-status/(:num)', 'Admin::updateBookingStatus/$1');
    $routes->post('bookings/update-payment/(:num)', 'Admin::updatePaymentStatus/$1');
    
    // Room management
    $routes->get('rooms', 'Admin::rooms'); // **TAMBAH method untuk handle GET**
    $routes->post('rooms/update-status', 'Admin::updateRoomStatus');
    $routes->get('rooms/create', 'Admin::createRoom'); // **TAMBAH jika diperlukan**
    $routes->delete('rooms/delete/(:num)', 'Admin::deleteRoom/$1'); // **TAMBAH jika diperlukan**
    
    // User management
    $routes->get('users', 'Admin::users'); // **TAMBAH method untuk handle GET**
});


// Tambahkan routes untuk room operations
$routes->group('room', function($routes) {    
    $routes->post('get-available', 'RoomController::getAvailable');
    $routes->get('get-available', 'RoomController::getAvailable');
});