<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('registerProcess', 'Auth::registerProcess');

$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('dashboard', 'AdminController::index');
    $routes->get('services/create', 'AdminController::createService');
    $routes->post('services/store', 'AdminController::storeService');
    
    $routes->get('services/edit/(:num)', 'AdminController::editService/$1');
    $routes->post('services/update/(:num)', 'AdminController::updateService/$1');
    $routes->get('services/delete/(:num)', 'AdminController::deleteService/$1');

    $routes->get('schedules', 'ScheduleController::index');
    $routes->post('schedules/store', 'ScheduleController::store');
    $routes->get('schedules/delete/(:num)', 'ScheduleController::delete/$1');

    $routes->get('bookings', 'AdminController::bookings');
    $routes->post('bookings/confirm/(:num)', 'AdminController::confirmBooking/$1');
    

    $routes->get('teknisi', 'AdminController::teknisi');
    $routes->post('teknisi/store', 'AdminController::storeTeknisi');
    $routes->get('teknisi/delete/(:num)', 'AdminController::deleteTeknisi/$1');
});

$routes->group('teknisi', ['filter' => 'role:teknisi'], static function ($routes) {
    $routes->get('jadwal', 'TeknisiController::index');
    $routes->get('booking/update-status/(:num)/(:alpha)', 'TeknisiController::updateStatus/$1/$2');
});

$routes->group('pelanggan', ['filter' => 'role:pelanggan'], static function ($routes) {
    $routes->get('booking', 'BookingController::index');
    $routes->get('booking/create', 'BookingController::create');
    $routes->post('booking/store', 'BookingController::store');
    $routes->get('booking/cancel/(:num)', 'BookingController::cancel/$1');
    $routes->get('payment/(:num)', 'PaymentController::pay/$1');
    $routes->get('payment/success/(:num)', 'PaymentController::success/$1');
});

$routes->group('api', ['filter' => 'apikey'], static function ($routes) {
    $routes->get('services', 'Api\ServiceEndpoint::index');
    $routes->get('services/(:num)', 'Api\ServiceEndpoint::show/$1');
    $routes->get('booking-status/(:num)', 'Api\BookingEndpoint::status/$1');
});