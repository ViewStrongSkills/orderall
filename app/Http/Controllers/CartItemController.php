<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Cart;
use App\CartItem;
use App\CartExtra;
use App\Business;
use App\MenuItem;
use App\User;

class CartItemController extends Controller
{
      public function add(Request $request)
      {
        $cart_created = false;
        $user = Auth::user();
        $object = json_decode($request->getContent());
        $menuitem = MenuItem::find($object->menuitem);
        $business_id = $menuitem->menu->business->id;
        // Check if Business is currently open
        if(!Business::open()->find($business_id)){
          return response(['message' => 'This restaurant is currently closed'], 422);
        }

        if (!$cart = Cart::exists($user->id, $business_id)) {
          $cart = $user->carts()->create([
            'business_id' => $business_id
          ]);
          $cart_created = true;
        }
        else {
          $cart = Cart::where('business_id', $business_id)->where('user_id', $user->id)->first();
        }

        // TODO: Check if item exists and belongs to the appropriate business

        $cartitem = $cart->cartitems()->create([
          'menu_item_id' => $menuitem->id
        ]);

        foreach ($object->menuextras as $value) {
          if ($value) {
            $cartextra = new CartExtra;
            $cartextra->menu_extra_id = $value;
            $cartextra->cart_item_id = $cartitem->id;
            $cartextra->save();
          }
        }

        $cartitem->comments = $object->comments;
        $cartitem->save();

        //check cart total
        if($cart->total > 999.99){
          $cartitem->delete();
          return response(['message' => 'Can not add item. The cart total is higher than 999.99'], 422);
        }
        if (count($cart->cartitems) > 1) {
          $data = array('view' => view('carts.cartitems', ['cart' => $cart])->render(), 'total' => $cart->total, 'orderable' => $cart->orderable);
          return json_encode($data);
        }
        else {
          return view('carts.cart', ['cart' => $cart]);
        }
      }

      public function destroy($id)
      {
        $cartitem = CartItem::find($id);

        if (!$cartitem->isValid())
          return 'You can not delete this item';

        $cart = $cartitem->cart;
        $cartitem->cartextras()->delete();
        $cartitem->delete();

        if(count($cart->cartitems) == 0){
          $cart->delete();
          return 'RELOAD';
        }

        return 'KEEP';
      }

      public function setcomments($id, Request $request)
      {
          $cartitem = CartItem::find($id);
          if ($cartitem->cart->user != Auth::user()) {
            return;
          }

          $request->validate([
            'comments' => ['nullable', 'string', 'max:127']
          ]);

          if ($request->input('comments')) {
            $cartitem->comments = $request->input('comments');
          }
          else {
            $cartitem->comments = null;
          }
          $cartitem->save();
          return "Successfully changed comment";
      }
}
