<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartExtra extends Model
{
    public function cartitem()
    {
      return $this->belongsTo('App\CartItem', 'cart_item_id');
    }
    public function menuextra()
    {
      return $this->belongsTo('App\MenuExtra', 'menu_extra_id');
    }
}
