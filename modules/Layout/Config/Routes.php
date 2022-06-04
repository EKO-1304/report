<?php

//$routes->get('/homee', 'Modules\FrontEndHome\Controllers\Home::index');

$routes->group('/', ['namespace' => 'Modules\Layout\Controllers'], function($routes){
    $routes->get('', 'Layout::index');
    $routes->get('/admin', 'Layout::index');
    $routes->get('/manage-home', 'Layout::home');
});
