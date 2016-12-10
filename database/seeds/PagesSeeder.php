<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{

    public function run()
    {

        if (Schema::hasTable('extension_manager')) {
                if(\DB::table('extension_manager')
                        ->where('name','Pages')
                        ->where('vendor','ExtensionsValley')
                        ->count() ==  0 ){
                     $data = [
                        'name' => 'Pages'
                        ,'vendor' => 'ExtensionValley'
                        ,'description' => 'Page component for laflux'
                        ,'package_type' => 'laflux-component'
                        ,'version' => '1.0.0'
                        ,'is_paid' => '0'
                        ,'status' => 0
                        ,'icon' =>'packages/extensionsvalley/dashboard/package_icons/icon.png'
                        ,'update_url' => 'https://github.com/LaFlux/Pages'
                        ,'author' => 'LaFlux'
                        ,'website' => 'https://github.com/LaFlux/Pages'
                        ,'contact_email' => 'support@laflux.com'
                        ,'created_at' => date('Y-m-d h:i:s')
                        ,'updated_at' => date('Y-m-d h:i:s')

                    ];

                    \DB::table('extension_manager')->insert($data);
                }
        }
    }
}
