<?php

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth:admin']], function () {
    Route::get('/manageextension', [
        'name' => 'Manage Extension',
        'as' => 'extensionsvalley.admin.manageextension',
        'uses' => 'ExtensionsValley\Dashboard\ExtensionController@getIndex',
    ]);
    Route::get('/addnewpackage', [
        'name' => 'Add new Package',
        'as' => 'extensionsvalley.admin.addnewpackage',
        'uses' => 'ExtensionsValley\Dashboard\ExtensionController@addNewPackage',
    ]);
    Route::post('/uploadextension', [
        'name' => 'upload extension',
        'as' => 'extensionsvalley.admin.uploadextension',
        'uses' => 'ExtensionsValley\Dashboard\ExtensionController@uploadPackage',
    ]);
    Route::get('/activatepackage/{id}', [
        'name' => 'Activate Package',
        'as' => 'extensionsvalley.admin.activatepackage',
        'uses' => 'ExtensionsValley\Dashboard\ExtensionController@activatePackage',
    ]);
    Route::get('/disablepackage/{id}', [
        'name' => 'Deactivate Package',
        'as' => 'extensionsvalley.admin.disablepackage',
        'uses' => 'ExtensionsValley\Dashboard\ExtensionController@disablePackage',
    ]);
    Route::get('/uninstallpackage/{id}', [
        'name' => 'Uninstall Package',
        'as' => 'extensionsvalley.admin.uninstallpackage',
        'uses' => 'ExtensionsValley\Dashboard\ExtensionController@uninstallPackage',
    ]);
});
