<?php


$routes->group('/', ['namespace' => 'Modules\Perusahaan\Controllers'], function($routes){
 
    $routes->get('/manage-input-laporan', 'DataPerusahaan::inputlaporan',['filter' => 'permission:manage-input-laporan']);
    $routes->post('/manage-input-laporan-save', 'DataPerusahaan::inputlaporansave',['filter' => 'permission:manage-input-laporan']);
    
    $routes->get('/manage-nasabah/view/(:any)', 'DataPerusahaan::viewnasabah/$1',['filter' => 'permission:manage-nasabah']);
    $routes->get('/rekap-data-nasabah/view/(:any)', 'DataPerusahaan::viewnasabah/$1',['filter' => 'permission:manage-nasabah']);
    
    $routes->get('/manage-nasabah', 'DataPerusahaan::datanasabah',['filter' => 'permission:manage-nasabah']);
    $routes->post('/manage-nasabah-json', 'DataPerusahaan::datanasabahjson',['filter' => 'permission:manage-nasabah']);
    
    $routes->get('/manage-nasabah/edit/(:any)', 'DataPerusahaan::editlaporan/$1',['filter' => 'permission:manage-input-laporan']);
    $routes->post('/manage-input-laporan-update', 'DataPerusahaan::updatelaporansave',['filter' => 'permission:manage-input-laporan']);
    
    $routes->post('/manage-input-laporan-delete', 'DataPerusahaan::deletelaporansave',['filter' => 'permission:manage-input-laporan']);
    
    $routes->get('/rekap-nasabah-cetak-excel', 'DataPerusahaan::cetak_excel',['filter' => 'permission:manage-nasabah-cetak-excel']);
    $routes->post('/manage-nasabah-cetak-excel', 'DataPerusahaan::cetakexcel',['filter' => 'permission:manage-nasabah-cetak-excel']);


    $routes->get('/rekap-data-nasabah', 'DataPerusahaan::rekapdatanasabah',['filter' => 'permission:rekap-data-nasabah']);
    $routes->post('/rekap-data-nasabah-json', 'DataPerusahaan::rekapdatanasabahjson',['filter' => 'permission:rekap-data-nasabah']);
    
    $routes->get('/rekap-data-staf', 'DataPerusahaan::rekapdatastaf',['filter' => 'permission:rekap-data-staf']);
    $routes->post('/rekap-data-staf-json', 'DataPerusahaan::rekapdatastafjson',['filter' => 'permission:rekap-data-staf']);
    
    $routes->get('/manage-bahan-presentasi', 'DataBahan::bahanpresentasi',['filter' => 'permission:manage-bahan-presentasi']);
    $routes->post('/manage-bahan-presentasi-json', 'DataBahan::bahanpresentasijson',['filter' => 'permission:manage-bahan-presentasi']);
    $routes->get('/manage-bahan-presentasi/tambah', 'DataBahan::bahanpresentasitambah',['filter' => 'permission:manage-bahan-presentasi-tambah']);
    $routes->post('/manage-bahan-presentasi-tambah', 'DataBahan::bahanpresentasisave',['filter' => 'permission:manage-bahan-presentasi-tambah']);
    $routes->get('/manage-bahan-presentasi/edit/(:any)', 'DataBahan::bahanpresentasiedit/$1',['filter' => 'permission:manage-bahan-presentasi-edit']);
    $routes->post('/manage-bahan-presentasi-edit', 'DataBahan::bahanpresentasiupdate',['filter' => 'permission:manage-bahan-presentasi-edit']);
    $routes->post('/manage-bahan-presentasi-delete', 'DataBahan::bahanpresentasidelete',['filter' => 'permission:manage-bahan-presentasi-delete']);
    
});
