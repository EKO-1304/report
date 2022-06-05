<?php


$routes->group('/', ['namespace' => 'Modules\DaftarMobil\Controllers'], function($routes){

    $routes->post('/manage-tujuan-mobil-json', 'DataDaftarMobil::tujuanmobiljson',['filter' => 'permission:manage-mobil']);
    $routes->post('/manage-tujuan-mobil-json-2', 'DataDaftarMobil::tujuanmobiljson2',['filter' => 'permission:manage-mobil']);

    $routes->get('/manage-mobil/tambah', 'DataDaftarMobil::inputmobil',['filter' => 'permission:manage-mobil']);
    $routes->post('/manage-mobil-save', 'DataDaftarMobil::inputmobilsave',['filter' => 'permission:manage-mobil']);

    $routes->get('/manage-mobil', 'DataDaftarMobil::datamobil',['filter' => 'permission:manage-mobil']);
    $routes->post('/manage-mobil-json', 'DataDaftarMobil::datamobiljson',['filter' => 'permission:manage-mobil']);

    $routes->get('/manage-mobil/edit/(:any)', 'DataDaftarMobil::editmobil/$1',['filter' => 'permission:manage-mobil']);
    $routes->post('/manage-mobil-update', 'DataDaftarMobil::editmobiludpate',['filter' => 'permission:manage-mobil']);

    $routes->post('/manage-mobil-delete', 'DataDaftarMobil::mobildelete',['filter' => 'permission:manage-mobil']);

    $routes->post('/manage-mobil-serahkan', 'DataDaftarMobil::serahkan',['filter' => 'permission:manage-mobil']);
    $routes->post('/manage-mobil-selesai', 'DataDaftarMobil::selesai',['filter' => 'permission:manage-mobil']);
    $routes->post('/manage-mobil-batal', 'DataDaftarMobil::batal',['filter' => 'permission:manage-mobil']);



});
