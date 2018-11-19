<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuExtra extends Model
{

		protected $fillable = ['name', 'price', 'menu_extra_category_id'];

    public function item()
    {
      return $this->belongsTo('App\MenuItem', 'menu_item_id');
    }

    public function cartextras()
    {
      return $this->hasMany('App\CartExtra');
    }

    public function category()
    {
      return $this->belongsTo('App\MenuExtraCategory', 'menu_extra_category_id');
    }

    // MUTATORS
    public function setNameAttribute($value)
    {
      $this->attributes['name'] = ucfirst($value);
    }

    public function update(array $attributes = [], array $options = [])
    {
      if (!isset($attributes['menu_extra_category_id'])) {
        $attributes['menu_extra_category_id'] = 0;
      }

      parent::update($attributes);
      return $this;
    }

}
