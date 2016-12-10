<?php

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{

    public function run()
    {

       if (Schema::hasTable('extension_manager')) {
                if(\DB::table('extension_manager')
                        ->where('name','Modulemanager')
                        ->where('vendor','ExtensionsValley')
                        ->count() ==  0 ){
                     $data = [
                        'name' => 'Modulemanager'
                        ,'vendor' => 'ExtensionValley'
                        ,'description' => 'Module manager for laflux platform'
                        ,'package_type' => 'laflux-package'
                        ,'version' => '1.0.0'
                        ,'is_paid' => '0'
                        ,'status' => 0
                        ,'icon' =>'packages/extensionsvalley/dashboard/package_icons/icon.png'
                        ,'update_url' => 'https://github.com/LaFlux/Modulemanager'
                        ,'author' => 'LaFlux'
                        ,'website' => 'https://github.com/LaFlux/Modulemanager'
                        ,'contact_email' => 'support@laflux.com'
                        ,'created_at' => date('Y-m-d h:i:s')
                        ,'updated_at' => date('Y-m-d h:i:s')

                    ];

                    \DB::table('extension_manager')->insert($data);
                }
            }
    }
}
