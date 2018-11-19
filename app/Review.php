<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  protected $fillable = ['rating', 'content', 'user_id', 'menu_item_id', 'created_at'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function menuitem()
  {
    return $this->belongsTo('App\MenuItem', 'menu_item_id');
  }
}
