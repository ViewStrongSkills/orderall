<div class="cart-box">
    <div class="row">
        <div class="img-cart-item">
            <img
                @if($element->image_path)
                src="{{Storage::url('images/menuitems/'.$element->image_path.'.jpg') }}"
                @else
                src="{{asset('images/default.svg')}}"
                @endif
                style="width:100%;"alt="">
            <div class="comments-up-down">
                <span>Comment</span>
                <img class="comments-arrow flip" src="{{asset('images/extra-right-arrow.svg')}}"/>
            </div>
        </div>
        <div class="cartitem-info">
            <div class="cartitem-stuff">
                <h2 class="mb-10 mt-10 font-bold">{{$element->name}}</h2>
                <div class="clear">
                    <span id="itemprice" class="item-price" price="{{$element->price - $element->discount}}">
                        <span class="col-orange v-middle">$</span>
                        <span class="price-no">
                            {{number_format($element->price - $element->discount, 2)}}
                        </span>
                    </span>
                    <span id="extrastotal" class="extras-total" price="{{$cartitem->cartextras->sum('menuextra.price')}}">
                        <span class="col-orange v-middle">+</span>
                        <span class="price-no extras-total-price">
                            {{number_format($cartitem->cartextras->sum('menuextra.price'), 2)}}
                        </span>
                    </span>
                </div>
                <div class="cart-total mt-10">
                    <span>Total:</span>
                    <span>$</span>
                    <span class="cartitem-total totalprice" price="{{($element->price - $element->discount) + $cartitem->cartextras->sum('menuextra.price')}}">{{number_format(($element->price - $element->discount) + $cartitem->cartextras->sum('menuextra.price'), 2)}}</span>
                </div>
                <button class="delete-icon" onClick="removeItem(this, {{$cartitem->id}}, $(this).parent().parent())" type="button">
                    <img width="14" src="{{URL::to('/images/close-btn-cart.svg')}}" alt="remove-product">
                </button>
            </div>

        </div>
    </div>
    <div class="form-group comments-box" style="display: none;">
        <input class="form-control" placeholder="Comments" name="comments{{$element->id}}" id="comments{{$element->id}}" value="{{$cartitem->comments}}" type="text" maxlength="127" onfocusout="setcomment({{$cartitem->id}}, this)">
    </div>
    @if (count($element->extras) > 0)
    <div class="extras-add-div show-extras">
        <span class="extras-clickable">Extras</span>
        <img class="show-extra-arrow comments-arrow extras-clickable" src="{{asset('images/extra-right-arrow.svg')}}"/>
        @if (count($element->extras) > 0)
        <div class="extras-div" style="display:none;">
            <div id="extras">
                <table class="extra-table mb-0">
                    @include('carts.categorized-new')
                    @include('carts.uncategorized-new')
                </table>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
