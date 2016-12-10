<?php

use ExtensionsValley\Dashboard\Models\User;
use Illuminate\Database\Seeder;

class ExtensionManagerSeeder extends Seeder
{

    public function run()
    {


            $data = [
                        'name' => 'Dashboard'
                        ,'vendor' => 'ExtensionsValley'
                        ,'description' => 'Core Package'
                        ,'version' => '1.0.0'
                        ,'is_paid' => '1'
                        ,'status' => 1
                        ,'package_type' =>'laflux-package'
                        ,'icon' =>'packages/extensionsvalley/dashboard/package_icons/icon.png'
                        ,'update_url' => 'https://github.com/LaFlux/Dashboard'
                        ,'author' => 'LaFlux'
                        ,'website' => 'http://laflux.com/'
                        ,'contact_email' => 'support@laflux.com'
                        ,'created_at' => date('Y-m-d h:i:s')
                        ,'updated_at' => date('Y-m-d h:i:s')

                    ];

        \DB::table('extension_manager')
            ->insert($data);


    }
}
