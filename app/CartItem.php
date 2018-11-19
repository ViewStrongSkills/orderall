<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CartItem extends Model
{
  protected $table = 'cart_items';
  protected $fillable = ['menu_item_id'];


    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function menuitem()
    {
      return $this->belongsTo('App\MenuItem', 'menu_item_id');
    }

    public function cart()
    {
      return $this->belongsTo('App\Cart');
    }

    public function cartextras()
    {
      return $this->hasMany('App\CartExtra', 'cart_item_id');
    }

    public function isValid()
    {
      if ($this->cart->user->id != Auth::user()->id) {
        return false;
      }

      return true;

    }

}
