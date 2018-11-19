<?php

use Illuminate\Database\Seeder;

class RolesSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			$this->call(ModulesTableSeeder::class);
			$this->call(PermissionsTableSeeder::class);
      $this->call(RolesTableSeeder::class);
			$this->call(UsersTableSeeder::class);
    }
}
