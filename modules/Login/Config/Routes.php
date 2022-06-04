<?php


$routes->group('/', ['namespace' => 'Modules\Login\Controllers'], function($routes){


    //LOGIN
    $routes->get('/login', 'Login::index//login/register');
    $routes->get('/register', 'Login::register//register/login');
    $routes->get('/forgot', 'Login::forgot//forgot/login');
    $routes->get('/reset-password', 'Login::reset//reset-password');


});
