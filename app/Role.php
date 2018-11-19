<?php

namespace App;

use Laratrust\Models\LaratrustRole;
use App\Permission;
use App\Module;
use DB;
use Auth;

class Role extends LaratrustRole
{
	protected $fillable = ['name', 'display_name', 'description', 'default_module'];

	public function attachPermissions($permissions, $role_id = null)
	{

		Permission::updatePermissionsList();
		DB::table('permission_role')->where('permission_role.role_id', $role_id)->delete();
		if(!empty($permissions)){
			$permissionsList = Permission::get();
		  foreach ($permissions as $key => $value) {
	      $p = $permissionsList->where('name', $key)->first();
	      $this->attachPermission($p->id);
		  }
		}
	}

	// SCOPES
	public function scopeUserRoles($query)
	{
		return $query->where('name', '!=', 'Developer');
	}

	public function scopeTogglableRoles($query)
	{
		return $query->whereNotIn('name', ['Developer', 'Admin']);
	}

	public function getEditableAttribute()
	{
		return $this->name != 'Developer';
	}

	public function getDeleteableAttribute()
	{
		return $this->editable;
	}

	public static function getDeveloperID()
	{
		return self::where('name', 'Developer')->first()->id;
	}

}
