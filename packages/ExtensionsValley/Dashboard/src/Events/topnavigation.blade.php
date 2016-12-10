<?php
namespace ExtensionsValley\Dashboard\Events;


\Event::listen('admin.topnavigation.groups', function ($collection) {

    $collection->put('dashboard', [
                               'items' => [
                                     [
                                    'order' => '1'
                                    ,'title' => 'Packages'
                                    ,'layout' => 'Dashboard::dashboard.navigation.plugins',
                                    ],

                                    ['order' => '2'
                                    ,'title' => 'Messages'
                                    ,'layout' => 'Dashboard::dashboard.navigation.reviews',
                                    ],
                                    ],


                    ]);
});
