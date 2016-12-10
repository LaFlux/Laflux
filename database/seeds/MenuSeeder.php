<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{

    public function run()
    {

       if (Schema::hasTable('extension_manager')) {
                if(\DB::table('extension_manager')
                        ->where('name','Menumanager')
                        ->where('vendor','ExtensionsValley')
                        ->count() ==  0 ){
                     $data = [
                        'name' => 'Menumanager'
                        ,'vendor' => 'ExtensionValley'
                        ,'description' => 'Menumanager for laflux'
                        ,'package_type' => 'laflux-module'
                        ,'version' => '1.0.0'
                        ,'is_paid' => '0'
                        ,'status' => 0
                        ,'icon' =>'packages/extensionsvalley/dashboard/package_icons/icon.png'
                        ,'update_url' => 'https://github.com/LaFlux/Menumanager'
                        ,'author' => 'LaFlux'
                        ,'website' => 'https://github.com/LaFlux/Menumanager'
                        ,'contact_email' => 'support@laflux.com'
                        ,'created_at' => date('Y-m-d h:i:s')
                        ,'updated_at' => date('Y-m-d h:i:s')

                    ];

                    \DB::table('extension_manager')->insert($data);
                }
            }
    }
}
