<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Cart extends Model
{
    public $timestamps = false;
    protected $fillable = ['business_id'];

    //Items in this cart
    public function cartitems()
    {
      return $this->hasMany('App\CartItem');
    }

    //Extras in this cart
    public function cartextras()
    {
      return $this->hasManyThrough('App\CartExtra', 'App\CartItem');
    }

    //The user who owns this cart
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    //The business that this cart belongs to
    public function business()
    {
      return $this->belongsTo('App\Business');
    }

    // Check if cart exists
    public static function exists($user_id, $business_id)
    {
        return self::where([
            'user_id' => $user_id,
            'business_id' => $business_id,
        ])->first();

    }

    public function getOrderableAttribute()
    {
        $result = $this->requiredExtrasChosen();

        // some additional checks could go here

        return $result;
    }

    public function requiredExtrasChosen()
    {
        $result = true;

        foreach($this->cartitems as $cartitem){

            if($cartitem->menuitem->extracategories->isEmpty())
                continue;

            $menuextracategories = $cartitem->menuitem->extracategories;

            foreach ($menuextracategories as $cat) {

                if($cat->menuextras->isEmpty() || !$cat->required)
                    continue;

                foreach ($cat->menuextras as $menuextra) {
                    if($exists = $this->cartextras->firstWhere('menu_extra_id', $menuextra->id)){
                        $result = true;
                        break;
                    } else {
                        $result = false;
                    }
                }
                if($result == false) break;
            }


        }

        return $result;

    }

    // Get cart total
    public function getTotalAttribute()
    {
        $result = $this->cartitems->sum('menuitem.price');
        $result -= $this->cartitems->sum('menuitem.discount');
        $result += $this->cartextras->sum('menuextra.price');

        return $result;
    }

}
