<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	// create developer account
    	$developer = User::create([
        'first_name' => 'Joe',
    		'last_name' => 'Gibbs',
    		'email' => 'joe.gibbs0@gmail.com',
    		'password' => bcrypt('123123'),
    		'remember_token' => str_random(10),
        'developer' => 1,
        'email_token' => str_random(64),
        'unsub_token' => str_random(64),
  		]);
      $developer->attachRole(Role::where('name', 'Developer')->first());

    }
}
