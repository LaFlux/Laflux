<?php
namespace ExtensionsValley\Dashboard\Events;


\Event::listen('admin.menu.groups', function ($collection) {

    $collection->put('extensionsvalley.users', [
        'menu_text' => 'User Panel'
        , 'menu_icon' => '<i class="fa fa-user"></i>'
        , 'acl_key' => 'extensionsvalley.dashboard.userpanel'
        , 'sub_menu' => [
            '0' => [
                'link' => '/admin/ExtensionsValley/dashboard/list/users'
                , 'menu_text' => 'Manage Users'
                , 'acl_key' => 'extensionsvalley.dashboard.users'
            ],
            '1' => [
                'link' => '/admin/ExtensionsValley/dashboard/list/groups'
                , 'menu_text' => 'User Groups'
                , 'acl_key' => 'extensionsvalley.dashboard.groups'
            ]
        ],
    ]);


});
