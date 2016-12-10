<?php

use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{

    public function run()
    {

        $rolenames = array('Super Admin', 'Admin', 'Manager', 'Editors', 'Writers', 'Registered Users');
        foreach ($rolenames as $name) {
            $data[] = array('name' => $name, 'status' => '1', 'created_at' => date('Y-m-d h:i:s'));
        }
        \DB::table('groups')
            ->insert($data);
    }
}
