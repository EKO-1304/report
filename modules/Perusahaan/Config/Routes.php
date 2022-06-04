<?php


$routes->group('/', ['namespace' => 'Modules\Perusahaan\Controllers'], function($routes){

    $routes->get('/manage-input-laporan', 'DataPerusahaan::inputlaporan',['filter' => 'permission:manage-input-laporan']);
    $routes->post('/manage-input-laporan-save', 'DataPerusahaan::inputlaporansave',['filter' => 'permission:manage-input-laporan']);

    $routes->get('/manage-nasabah', 'DataPerusahaan::datanasabah',['filter' => 'permission:manage-nasabah']);
    $routes->post('/manage-nasabah-json', 'DataPerusahaan::datanasabahjson',['filter' => 'permission:manage-nasabah']);
    

});
