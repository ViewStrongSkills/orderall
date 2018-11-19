<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Module;
use App\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::create([
        	'name' => 'Developer',
          'display_name' => 'Developer'
      	]);

        DB::table('permission_role')->where('permission_role.role_id', $developer->id)->delete();
        foreach (Permission::get() as $permission) {
            $developer->attachPermission($permission);
        }

        $admin = Role::create([
            'name' => 'Admin',
            'display_name' => 'Administrator'
        ]);
        // $admin->attachPermissions(Permission::$initialPermissions);

        $user = Role::create([
            'name' => 'User',
            'display_name' => 'User'
        ]);
        // $admin->attachPermissions(Permission::$initialPermissions);

        $business = Role::create([
        	'name' => 'Business',
          'display_name' => 'Business'
      	]);

        $unauthuser = Role::create([
          'name' => 'UnauthUser',
          'display_name' => 'Unauthenticated User'
        ]);
        // $admin->attachPermissions(Permission::$initialPermissions);

    }
}
