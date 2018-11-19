<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MenuExtra;
use App\CartExtra;
use App\CartItem;
use App\Business;

class CartExtraController extends Controller
{
  public function add($id, $itemid)
  {
    $cartextra = new CartExtra;
    $cartextra->menu_extra_id = $id;
    $cartextra->cart_item_id = $itemid;
    $cartextra->save();

    $cart = $cartextra->cartitem->cart;

    // If Extra is categorized
    if ($category = MenuExtra::find($id)->category){
        $categorized = $category->menuextras->pluck('id');
        // Drop any cart extras of this category except just created
        $categorized->map(function($item, $key) use ($id, $cartextra){
          if($item != $id) {
            CartExtra::where(['menu_extra_id' => $item, 'cart_item_id' => $cartextra->cart_item_id])->delete();
          }
        });
    //check cart total
    } else if($cart->total > 999.99){
      $cartextra->delete();
      return response(['message' => 'Can not add item. The cart total is higher than 999.99'], 422);

    // Check if Business is currently open
    } else if(!Business::/*open()->*/find($cart->business->id)){
      $cartextra->delete();
      return response(['message' => 'This restaurant is currently closed'], 422);
    }
    if ($cart->orderable) {
      return 'orderable';
    }
    else {
      return null;
    }
  }

  public function destroy($id, $itemid)
  {
    $cart = CartItem::find($itemid)->cart;
    $cartextra = CartExtra::where([
      ['cart_item_id', '=', $itemid],
      ['menu_extra_id', '=', $id]
    ]);
    $cartextra->delete();
    if ($cart->orderable) {
      return 'orderable';
    }
    else {
      return null;
    }
  }
}
