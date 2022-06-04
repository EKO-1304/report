<?php


$routes->group('/', ['namespace' => 'Modules\Users\Controllers'], function($routes){

    // users
    // $routes->get('/manage-users', 'DataUsers::index',['filter' => 'role:super_administrator']);
    // $routes->post('/manage-tambah-users', 'DataUsers::tambah_users',['filter' => 'role:super_administrator']);
    // $routes->post('/manage-edit-users', 'DataUsers::edit_users',['filter' => 'role:super_administrator']);
    // $routes->post('/manage-delete-users', 'DataUsers::delete_users',['filter' => 'role:super_administrator']);

    $routes->get('/manage-users', 'DataUsers::index',['filter' => 'permission:manage-users']);
    $routes->post('/manage-users-json', 'DataUsers::user_json',['filter' => 'permission:manage-users']);
    $routes->get('/manage-users/tambah', 'DataUsers::tambahusers',['filter' => 'permission:manage-users-tambah']);
    $routes->post('/manage-tambah-users', 'DataUsers::tambah_users',['filter' => 'permission:manage-users-tambah']);
    $routes->get('/manage-users/edit/(:any)', 'DataUsers::editusers/$1',['filter' => 'permission:manage-users-edit']);
    $routes->post('/manage-edit-users', 'DataUsers::edit_users',['filter' => 'permission:manage-users-edit']);
    $routes->post('/manage-delete-users', 'DataUsers::delete_users',['filter' => 'permission:manage-users-delete']);

    $routes->get('/manage-users/profile/(:any)', 'DataUsers::profile/$1',['filter' => 'permission:manage-profile']);
    $routes->post('/manage-users-profile-edit', 'DataUsers::edit_profile',['filter' => 'permission:manage-profile']);
    $routes->post('/manage-users-profile-edit-adm', 'DataUsers::edit_profile_adm',['filter' => 'permission:manage-profile']);
    $routes->post('/manage-img-user-edit', 'DataUsers::imguseredit',['filter' => 'permission:manage-profile']);
    $routes->post('/manage-users-profile-password', 'DataUsers::gantipassword',['filter' => 'permission:manage-profile']);
   
    // groups completed
    $routes->get('/manage-groups', 'DataGroups::index',['filter' => 'role:super_administrator']);
    $routes->post('/manage-edit-groups', 'DataGroups::edit_groups',['filter' => 'role:super_administrator']);
    $routes->post('/manage-tambah-groups', 'DataGroups::tambah_groups',['filter' => 'role:super_administrator']);
    $routes->post('/manage-delete-groups', 'DataGroups::delete_groups',['filter' => 'role:super_administrator']);

    // permissions complete
    $routes->get('/manage-permissions', 'DataPermissions::index',['filter' => 'role:super_administrator']);
    $routes->post('/manage-edit-permissions', 'DataPermissions::edit_permissions',['filter' => 'role:super_administrator']);
    $routes->post('/manage-tambah-permissions', 'DataPermissions::tambah_permissions',['filter' => 'role:super_administrator']);
    $routes->post('/manage-delete-permissions', 'DataPermissions::delete_permissions',['filter' => 'role:super_administrator']);

    // groups permissions complete
    $routes->get('/manage-groups-permissions', 'DataGroupsPermissions::index',['filter' => 'role:super_administrator']);
    $routes->post('/manage-edit-groups-permissions', 'DataGroupsPermissions::edit_groups_permissions',['filter' => 'role:super_administrator']);
    $routes->post('/manage-tambah-groups-permissions', 'DataGroupsPermissions::tambah_groups_permissions',['filter' => 'role:super_administrator']);
    $routes->post('/manage-delete-groups-permissions', 'DataGroupsPermissions::delete_groups_permissions',['filter' => 'role:super_administrator']);

});
