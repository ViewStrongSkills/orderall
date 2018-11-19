<?php

use Illuminate\Database\Seeder;
use App\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$modules = Module::getModules();
    	foreach ($modules as $key => $value) {
    		Module::create([
    			'route' => $key,
    			'title' => $value['title']
  			]);
    	}
    }
}
