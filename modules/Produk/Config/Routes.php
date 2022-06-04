<?php


$routes->group('/', ['namespace' => 'Modules\Produk\Controllers'], function($routes){

    //DATA PRODUK SAYA
    $routes->get('/produk-saya', 'DataProdukSaya::index',['filter' => 'permission:produk-saya']);
    $routes->post('/produk-saya-json', 'DataProdukSaya::produkjson',['filter' => 'permission:produk-saya']);
    $routes->post('/update-produk-status', 'DataProdukSaya::updateprodukstatus',['filter' => 'permission:produk-saya']);

    //DATA TAMBAH PRODUK BARU
    $routes->get('/tambah-produk-baru', 'DataTambahProduk::index',['filter' => 'permission:tambah-produk-baru']);
    $routes->post('/save-produk-baru', 'DataTambahProduk::saveproduk',['filter' => 'permission:tambah-produk-baru']);

    //DATA EDIT PRODUK BARU
    $routes->get('/edit-produk/(:any)', 'DataEditProduk::index/$1',['filter' => 'permission:edit-produk-baru']);
    $routes->post('/update-produk', 'DataEditProduk::updateproduk',['filter' => 'permission:edit-produk-baru']);

    //DATA EDIT PRODUK BARU
    $routes->post('/delete-produk', 'DataProdukSaya::deleteproduk',['filter' => 'permission:produk-saya']);

    //DATA EXCEL PRODUK BARU
    $routes->get('/manage-tambah-export-excel', 'DataProdukExcel::temptambah',['filter' => 'permission:produk-saya']);
    $routes->post('/manage-tambah-produk-excel', 'DataProdukExcel::tambahdata',['filter' => 'permission:produk-saya']);

    $routes->get('/manage-edit-export-excel', 'DataProdukExcel::tempedit',['filter' => 'permission:produk-saya']);
    $routes->post('/manage-edit-produk-excel', 'DataProdukExcel::editdata',['filter' => 'permission:produk-saya']);
    

});
