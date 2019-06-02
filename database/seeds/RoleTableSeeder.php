<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // get all roles from model
        $roles = Role::$list;

        // seed to database each role
        foreach ($roles as $role) {
            $role_item = new Role;
            $role_item->name = $role;
            $role_item->save();
        }
    }
}
