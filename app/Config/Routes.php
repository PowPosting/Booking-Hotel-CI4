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

// ===== NOTIFICATIONS =====
$routes->group('notifications', function($routes) {
    $routes->get('/', 'Notifications::index');
    $routes->post('mark-read', 'Notifications::markRead');
    $routes->post('delete', 'Notifications::delete');
    $routes->post('mark-all-read', 'Notifications::markAllRead');
    $routes->post('clear-all', 'Notifications::clearAll');
});

// ===== BOOKING =====
$routes->group('booking', function($routes) {
    $routes->post('process', 'Booking::process');
    $routes->get('/', 'Booking::index');
    $routes->get('getNotifications', 'Booking::notifications');
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
    $routes->get('bookings/delete/(:num)', 'Admin::deleteBooking/$1');
    
    // Room management
    $routes->get('rooms', 'Admin::rooms'); // **TAMBAH method untuk handle GET**
    $routes->post('rooms/update-status', 'Admin::updateRoomStatus');
    $routes->get('rooms/create', 'Admin::createRoom'); // **TAMBAH jika diperlukan**
    $routes->post('rooms/create', 'Admin::createRoom'); // **TAMBAH untuk POST create**
    $routes->get('rooms/delete/(:num)', 'Admin::deleteRoom/$1'); // **TAMBAH jika diperlukan**
    
    // User management
    $routes->get('users', 'Admin::users'); // **TAMBAH method untuk handle GET**
    $routes->get('users/delete/(:num)', 'Admin::deleteUser/$1');
    
    // **TAMBAH: AJAX API endpoints**
    $routes->get('api/stats', 'Admin::getStats');
    $routes->get('api/recent-bookings', 'Admin::getRecentBookings');
    $routes->get('api/system-info', 'Admin::getSystemInfo');
    $routes->get('api/notifications', 'Admin::getNotifications');
    $routes->get('api/export/(:alpha)', 'Admin::exportData/$1');
    
    // **TAMBAH: AJAX CRUD endpoints**
    // Booking CRUD
    $routes->get('api/bookings', 'Admin::getBookings');
    $routes->post('api/bookings/update/(:num)', 'Admin::updateBookingAjax/$1');
    $routes->post('api/bookings/update', 'Admin::updateBookingAjax');
    $routes->delete('api/bookings/delete/(:num)', 'Admin::deleteBookingAjax/$1');
    $routes->post('api/bookings/delete', 'Admin::deleteBookingAjax');
    
    // Room CRUD
    $routes->get('api/rooms', 'Admin::getRooms');
    $routes->post('api/rooms/save/(:num)', 'Admin::saveRoomAjax/$1');
    $routes->post('api/rooms/save', 'Admin::saveRoomAjax');
    $routes->delete('api/rooms/delete/(:num)', 'Admin::deleteRoomAjax/$1');
    $routes->post('api/rooms/delete', 'Admin::deleteRoomAjax');
    
    // User CRUD
    $routes->get('api/users', 'Admin::getUsers');
    $routes->post('api/users/save/(:num)', 'Admin::saveUserAjax/$1');
    $routes->post('api/users/save', 'Admin::saveUserAjax');
    $routes->delete('api/users/delete/(:num)', 'Admin::deleteUserAjax/$1');
    $routes->post('api/users/delete', 'Admin::deleteUserAjax');
});


// Tambahkan routes untuk room operations
$routes->group('room', function($routes) {    
    $routes->post('get-available', 'RoomController::getAvailable');
    $routes->get('get-available', 'RoomController::getAvailable');
});