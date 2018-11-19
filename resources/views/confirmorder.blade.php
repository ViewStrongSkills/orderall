@extends('layouts.master')

@section('page-title', 'Confirm your order')
@section('content')
    @push('scripts')
    {{HTML::script('js/map-style.js')}}
    {{HTML::script('js/cart.js')}}
    @endpush

    <div class="clearfix"></div>
    <div class="container">
        <h1 class="mt-40 txtclr">
            Order from <a class="edit-link" href="{{URL::to('/businesses/' . $cart->business_id)}}">{{$cart->business->name}}</a>
        </h1>
        <div class="row d-flex business-map-sec mb-40">
            <div class="col-sm-6 col-xs-12 pad-l-0 d-flex-box">
                {{ Form::open(array('url' => 'finish')) }}
                {{ Form::hidden('business_id', $cart->business->id)}}
                <div class="order-confirm-page">
                    <!-- Includes the cart here -->
                    <div id="cart" class="at-confirmation-page">
                        @if (!$cart->requiredExtrasChosen())
                            <div class="alert alert-danger" role="alert">You must choose required extras</div>
                        @endif
                        @foreach ($cart->cartitems as $item)
                            @include('carts.cartitem-confirm', ['element' => $item->menuitem, 'cartitem' => $item])
                        @endforeach
                    </div>
                </div>
                <div class="cart-btn-custm">
                    {{ Form::submit('$' . number_format($cart->total, 2) . ' - Finish', ['class' => 'btn btn-primary confirmorder-button totalprice ', $cart->orderable ? null : 'disabled', 'id' => 'totalprice', 'style' => 'width:100%;']) }}
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 d-flex-box business-direction mt-20-xs">
                <div class="business-direction-map" style="max-height:750px;">
                    {!! Mapper::render() !!}
                </div>
            </div>
        </div>
    </div>


@endsection
