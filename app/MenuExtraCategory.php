<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuExtraCategory extends Model
{
	protected $fillable = ['name', 'menu_item_id', 'required'];
	public $timestamps = false;

	public function menuitem()
	{
		return $this->belongsTo('App\MenuItem');
	}

	public function menuextras()
	{
		return $this->hasMany('App\MenuExtra');
	}
}
