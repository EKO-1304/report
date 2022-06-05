<?php


$routes->group('/', ['namespace' => 'Modules\Staf\Controllers'], function($routes){

    $routes->get('/manage-staf', 'DataStaf::index',['filter' => 'permission:manage-staf']); 
    $routes->post('/manage-staf-json', 'DataStaf::staf_json',['filter' => 'permission:manage-staf']);
    
    $routes->get('/manage-staf/tambah', 'DataStaf::tambahstaf',['filter' => 'permission:manage-staf']);
    $routes->post('/manage-tambah-staf', 'DataStaf::tambah_staf',['filter' => 'permission:manage-staf']);
    $routes->get('/manage-staf/edit/(:any)', 'DataStaf::editstaf/$1',['filter' => 'permission:manage-staf']);
    $routes->post('/manage-edit-staf', 'DataStaf::edit_staf',['filter' => 'permission:manage-staf']);
    $routes->post('/manage-delete-staf', 'DataStaf::delete_staf',['filter' => 'permission:manage-staf']);

});
