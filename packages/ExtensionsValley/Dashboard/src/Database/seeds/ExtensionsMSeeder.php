<?php

use ExtensionsValley\Dashboard\Models\User;
use Illuminate\Database\Seeder;

class ExtensionsMSeeder extends Seeder
{

    public function run()
    {

       $data_list = array(

array('id'=>2, 'name'=>'Basetheme','vendor'=> 'ExtensionsValley','description'=> 'Basetheme Provieded with dashboard','version'=> '1.0.0','is_paid'=> 0,'status'=> 1,'package_type'=> 'laflux-theme', 'icon'=> 'packages/extensionsvalley/dashboard/package_icons/icon.png', 'update_url'=> 'https://github.com/LaFlux/Basetheme','author'=> 'ExtensionsValley ', 'website'=> 'https://github.com/LaFlux/Basetheme', 'contact_email'=> 'support@laflux.com','created_at' => '2016-11-25 06:14:27','updated_at' => '2016-11-25 06:37:25', 'deleted_at'=> NULL),
array('id'=>3, 'name'=>'Modulemanager','vendor'=> 'ExtensionsValley','description'=> 'Modulemanager helps to install or uninstall extensions in LaFlux','version'=> '1.0.0','is_paid'=> 0,'status'=> 1,'package_type'=> 'laflux-package', 'icon'=> 'packages/extensionsvalley/dashboard/package_icons/icon.png', 'update_url'=> 'https://github.com/LaFlux/Modulemanager','author'=> 'ExtensionsValley ', 'website'=> 'https://github.com/LaFlux/Modulemanager', 'contact_email'=> 'support@laflux.com', 'created_at' =>'2016-11-25 06:52:15','updated_at' => '2016-11-25 06:55:29', 'deleted_at'=> NULL),
array('id'=>4, 'name'=>'Pages','vendor'=> 'ExtensionsValley','description'=> 'Page component will helps you to create dynamic pages','version'=> '1.0.0','is_paid'=> 0,'status'=> 1,'package_type'=> 'laflux-component', 'icon'=> 'packages/extensionsvalley/dashboard/package_icons/icon.png', 'update_url'=> 'https://github.com/LaFlux/Pages','author'=> 'ExtensionsValley ', 'website'=> 'https://github.com/LaFlux/Pages', 'contact_email'=> 'support@laflux.com','created_at' => '2016-11-25 06:53:11','updated_at' => '2016-11-25 06:56:14', 'deleted_at'=> NULL),
array('id'=>5, 'name'=>'Menumanager','vendor'=> 'ExtensionsValley','description'=> 'Dynamic menu manage extensions', 'version'=>'1.0.0','is_paid'=> 0, 'status'=>1,'package_type'=> 'laflux-module', 'icon'=> 'packages/extensionsvalley/dashboard/package_icons/icon.png', 'update_url'=> 'https://github.com/LaFlux/Menumanager','author'=> 'ExtensionsValley ', 'website'=> 'https://github.com/LaFlux/Menumanager', 'contact_email'=> 'support@laflux.com','created_at' => '2016-11-25 06:53:17','updated_at' => '2016-11-25 06:53:37', 'deleted_at'=> NULL),
array('id'=>6, 'name'=>'Banners','vendor'=> 'ExtensionsValley','description'=> 'Banner Module for managing banners in the front end','version'=> '1.0.0','is_paid'=> 0,'status'=> 1,'package_type'=> 'laflux-module', 'icon'=> 'packages/extensionsvalley/dashboard/package_icons/icon.png', 'update_url'=> 'https://github.com/LaFlux/Banners','author'=> 'ExtensionsValley ', 'website'=> 'https://github.com/LaFlux/Banners', 'contact_email'=> 'support@laflux.com','created_at' => '2016-11-28 23:59:59','updated_at' => '2016-12-01 02:38:57', 'deleted_at'=> NULL)

);
        \DB::table('extension_manager')
            ->insert($data_list);


    }
}
