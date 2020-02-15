<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Read Role',      'for' => 'role']);
        Permission::create(['name' => 'Create Role',      'for' => 'role']);
        Permission::create(['name' => 'Update Role',      'for' => 'role']);
        Permission::create(['name' => 'Delete Role',      'for' => 'role']);

        Permission::create(['name' => 'Read User',      'for' => 'user']);
        Permission::create(['name' => 'Create User',      'for' => 'user']);
        Permission::create(['name' => 'Update User',      'for' => 'user']);
        Permission::create(['name' => 'Delete User',      'for' => 'user']);
    }
}
