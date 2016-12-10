<?php

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth:admin']], function () {
    Route::get('/dashboard', [
        'name' => 'Dashboard',
        'as' => 'extensionsvalley.admin.dashboard',
        'uses' => 'ExtensionsValley\Dashboard\DashboardController@getDashboard',
    ]);

    /* Common routes for CRUD*/

    Route::get('{vendor}/{namespace}/list/{tables}', [
        'middleware' => 'acl',
        'name' => 'View tables',
        'as' => 'extensionsvalley.admin.view.list',
        'uses' => 'ExtensionsValley\Dashboard\DashboardController@getBasicView',
    ]);
    /* Common routes for CRUF */

    /* Common routes for Ajax Tables*/

    Route::any('{namespace}/list/{tables}/ajaxview', [
        'name' => 'View tables',
        'as' => 'extensionsvalley.admin.ajax.list',
        'uses' => 'ExtensionsValley\Dashboard\DashboardController@getAjaxView',
    ]);

    /* Common routes for Ajax Tables */

    Route::post('/actions', [
        'name' => 'Authendication',
        'as' => 'extensionsvalley.admin.actions',
        'uses' => 'ExtensionsValley\Dashboard\DashboardController@getCommonAction',
    ]);

    Route::get('/aclmanager', [
        'name' => 'ACL Manager',
        'as' => 'extensionsvalley.admin.permission',
        'uses' => 'ExtensionsValley\Dashboard\ACLController@getIndex',
    ]);

    Route::get('/gensettings', [
        'name' => 'General Settings',
        'as' => 'extensionsvalley.admin.gensettings',
        'uses' => 'ExtensionsValley\Dashboard\DashboardController@getSettings',
    ]);

    Route::post('/setpermission', [
        'name' => 'ACL Manager',
        'as' => 'extensionsvalley.admin.setpermission',
        'uses' => 'ExtensionsValley\Dashboard\ACLController@setPermission',
    ]);

    Route::post('/updatesettings', [
        'name' => 'update settings',
        'as' => 'extensionsvalley.admin.updatesettings',
        'uses' => 'ExtensionsValley\Dashboard\DashboardController@updateSettings',
    ]);

});
