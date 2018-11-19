<?php

use Illuminate\Database\Seeder;
use App\Module;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::updatePermissionsList();
    }
}
