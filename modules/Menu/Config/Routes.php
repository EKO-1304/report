<?php


$routes->group('/', ['namespace' => 'Modules\Menu\Controllers'], function($routes){

    
    $routes->get('/manage-menu', 'DataMenu::menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-tambah-menu', 'DataMenu::tambah_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-edit-menu', 'DataMenu::edit_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-delete-menu', 'DataMenu::delete_menu',['filter' => 'role:super_administrator']);
    
    $routes->get('/manage-menu-group', 'DataGroupMenu::group_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-tambah-menu-group', 'DataGroupMenu::tambah_group_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-edit-menu-group', 'DataGroupMenu::edit_group_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-delete-menu-group', 'DataGroupMenu::delete_group_menu',['filter' => 'role:super_administrator']);
    
    $routes->get('/manage-sub-menu', 'DataSubMenu::sub_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-tambah-sub-menu', 'DataSubMenu::tambah_sub_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-edit-sub-menu', 'DataSubMenu::edit_sub_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-delete-sub-menu', 'DataSubMenu::delete_sub_menu',['filter' => 'role:super_administrator']);

    $routes->get('/manage-sub-sub-menu', 'DataSubSubMenu::sub_sub_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-tambah-sub-sub-menu', 'DataSubSubMenu::tambah_sub_sub_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-edit-sub-sub-menu', 'DataSubSubMenu::edit_sub_sub_menu',['filter' => 'role:super_administrator']);
    $routes->post('/manage-delete-sub-sub-menu', 'DataSubSubMenu::delete_sub_sub_menu',['filter' => 'role:super_administrator']);




});
