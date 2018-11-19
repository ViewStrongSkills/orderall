<?php

namespace App;

use Laratrust\Models\LaratrustPermission;
use App\Module;

class Permission extends LaratrustPermission
{
    protected $fillable = ['name', 'display_name', 'description'];
    public static $initialPermissions = [
      // 'admin.read' => 'on',
      // 'admin.login' => 'on',
      // 'admin.logout' => 'on',
      // 'admin.my.profile.edit' => 'on',
      // 'admin.my.password.edit' => 'on',
    ];

    public static function updatePermissionsList()
    {
        $modules = Module::getModules();
      	foreach ($modules as $key => $value) {
      		foreach ($value['methods'] as $method) {
      			if (!Permission::where('name', $key.'.'.$method['key'])->first()) {
			    		Permission::create([
			    			'name' => $key . '.' . $method['key'],
			    			'display_name' => $key . '.' . $method['key'],
			    			'description' => ''
			  			]);      				
      			}
      		}
	    	}

    }

}
