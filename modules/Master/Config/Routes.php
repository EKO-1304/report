<?php


$routes->group('/', ['namespace' => 'Modules\Master\Controllers'], function($routes){

    
    $routes->get('/manage-staf', 'DataStafSenior::staf',['filter' => 'permission:manage-staf']);
    $routes->get('/manage-senior', 'DataStafSenior::senior',['filter' => 'permission:manage-senior']); 


});
