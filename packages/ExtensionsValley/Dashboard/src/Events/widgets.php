<?php
namespace ExtensionsValley\Dashboard\Events;


\Event::listen('admin.widgets.groups', function ($collection) {

	$collection->put('dashboard', [
                               'items' => [
                                     [
                                    'order' => '1'
                                    ,'col' => '12'
                                    ,'layout' => 'Dashboard::dashboard.widgets.tiles',
                                    ],

                                    ['order' => '2'
                                    ,'col' => '12'
                                    ,'layout' => 'Dashboard::dashboard.widgets.activities',
                                    ],
                                    ],


                    ]);

    $collection->put('another_pack', [
                               'items' => [
                                     [
                                    'order' => '3'
                                    ,'col' => '4'
                                    ,'layout' => 'Dashboard::dashboard.widgets.appversion',
                                    ],

                                    ['order' => '4'
                                    ,'col' => '4'
                                    ,'layout' => 'Dashboard::dashboard.widgets.devices',
                                    ],
                                    ['order' => '5'
                                    ,'col' => '4'
                                    ,'layout' => 'Dashboard::dashboard.widgets.quickstart',
                                    ],
                                    ],


                    ]);
});
