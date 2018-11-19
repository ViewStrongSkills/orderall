<div id="cartitems-container">
    <div class="container-fluid">
        <div class="scrollable-cart-sec">
            <div class="clearfix scrollable-cart" id="cart-cartitems" style="display:none;">
              @include('carts.cartitems')
            </div>
        </div>
        <div class="clear" style="cursor:pointer;">
            <div id="cart-orderbutton" class="btn btn-primary orderbutton-cart {{$cart->orderable ? null : 'disabled'}}">
                <div class="display-inline ">
                    <a class="display-inline orderbutton" href={{ URL::to('confirm/' . $cart->business->id)}}>$<span class="totalprice" id="totalprice">
                      {{number_format(($cart->total), 2)}}
                    </span> - Order</a>
                </div>
            </div>
        </div>
    </div>
</div>
