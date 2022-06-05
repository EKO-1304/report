<?php


$routes->group('/', ['namespace' => 'Modules\Master\Controllers'], function($routes){

    
    $routes->get('/manage-tujuan-mobil', 'DataTujuanMobil::index',['filter' => 'permission:manage-tujuan-mobil']);
    $routes->post('/manage-tujuan-mobil-save', 'DataTujuanMobil::tambahdata',['filter' => 'permission:manage-tujuan-mobi']);
    $routes->post('/manage-tujuan-mobil-update', 'DataTujuanMobil::updatedata',['filter' => 'permission:manage-tujuan-mobi']);
    $routes->post('/manage-tujuan-mobil-delete', 'DataTujuanMobil::deletedata',['filter' => 'permission:manage-tujuan-mobi']);
   
    
    $routes->get('/manage-sesi-mobil', 'DataSesiMobil::index',['filter' => 'permission:manage-sesi-mobil']);
    $routes->post('/manage-sesi-mobil-save', 'DataSesiMobil::tambahdata',['filter' => 'permission:manage-sesi-mobil']);
    $routes->post('/manage-sesi-mobil-update', 'DataSesiMobil::updatedata',['filter' => 'permission:manage-sesi-mobil']);
    $routes->post('/manage-sesi-mobil-delete', 'DataSesiMobil::deletedata',['filter' => 'permission:manage-sesi-mobil']);
   
});
