@php
  $user = Auth::user();
@endphp

@extends('layouts.master')

@section('page-title', $business->name)
@section('meta-description', $description)
@section('meta-keywords', $keywords)
@section('og-title', $business->name)
@section('og-description', $description)
@section('og-image', Storage::url($business->image_path))
@section('twitter-title', $business->name)
@section('twitter-description', $description)
@section('twitter-image', Storage::url($business->image_path))

@push('scripts')
  {{HTML::script('js/cart.js')}}
  {{HTML::script('js/map-style.js')}}
  {{HTML::script('js/menuitems.js')}}
  <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Restaurant",
    "@id": "{{'https://www.orderall.io/businesses/' . $business->id}}",
    "name": "{{$business->name}}",
    "image": [
      "{{Storage::url($business->image_path)}}"
    ],
    "address" :{
      "@type": "PostalAddress",
      "streetAddress": "{{$business->addressLine2}}",
      "addressLocality": "{{$business->locality}}",
      "addressRegion": "VIC",
      "postalCode": "{{$business->postcode}}",
      "addressCountry": "AU"
    },
    "aggregateRating": {
      "@type": "AggregateRating",
      @if(count($business->menuitemreviews) > 0)
      "ratingValue": "{{$business->shortreviews}}",
      @endif
      "bestRating": "100",
      "worstRating": "0",
      "ratingCount": "{{count($business->menuitemreviews)}}"
    },
    "geo":{
      "@type": "GeoCoordinates",
      "latitude": {{$business->xcoord}},
      "longitude": {{$business->ycoord}}
    }
  }
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="clearfix"></div>
    <br />
    <div class="row d-flex business-map-sec">
        <div class="col-md-4 col-sm-6 col-xs-12 pad-r-0 d-flex-box">
          <div class="map-search-box">
          @if($business->image_path)
          <div class="box-img">
            <img src="{{Storage::url($business->image_path)}}" style="height: 100%;width: 100%; @if(!$business->open) filter: brightness(25%);  @endif " alt="{{$business->name}}">
            </div>
          @else
          <div class="box-img">
            <img src="{{asset('images/default.svg')}}" @if(!$business->open) style="filter: brightness(25%);"  @endif alt="{{$business->name}}">
            </div>
          @endif
          <div class="map-box-body">
            @auth
            @if ($user->canEditBusiness($business))
              @permission('businesses.transactions')
                <div class="business-box-main">
                    <a href="{{route('businesses.edit', $business->id)}}" class="btn btn-outline-primary mr-1 btn-small">Edit Business</a>
                    @if (count($business->transactions) > 0)
                      <a class="btn btn-outline-primary mr-1 btn-small openbutton" href="{{route('businesses.transactions', $business->id)}}">Transactions</a>
                    @endif
                    <a class="btn btn-outline-primary mr-1 btn-small openbutton menuitems-create" href={{route('menuitems.create', $business->id)}}>Add Items</a>
                    <a class="btn btn-outline-primary openbutton menus-create btn-small" href={{route('menus.create', $business->id)}}>Add Menu</a>
                </div>
              @endpermission
            @endif
            @endauth
              <h1>{{ $business->name}}</h1>
              @include('layouts.tagbox')
              <ul class="search-box-description">
                @if ($business->website)
                <li>
                   <i class="icon"><img src="{{asset('images/earth.svg')}}" alt=""></i>
                  {{HTML::link($business->website)}}
                </li>
                @endif
                <li>
                   <i class="icon"><img src="{{asset('images/star-o.svg')}}" alt=""></i>
                  <span>{{$business->shortreviews}}</span>
                @endif
                </li>
                <li>
                   <i class="icon"><img src="{{ asset('images/map-marker.svg') }}"></i>
                   <span>{{$business->addressLine1 . ' ' . $business->addressLine2 . ', ' . $business->locality}}</span>
                </li>
                <li onclick="$('#sidebox-opening-hours').slideToggle(200); $('#opening-hours-box-icon img').toggleClass('flip');" style="cursor:pointer;">
                   <i class="icon"><img src="{{ asset('images/clock.svg') }}"></i>
                  @if($business->currentOpeningHours && $business->open)
                    <span id>{{$business->currentOpeningHours}}</span>
                  @else
                    <span>Currently closed</span>
                  @endif
                   <i id="opening-hours-box-icon" class="icon"><img src="{{ asset('images/chevron-circle-down.svg') }}"></i>
                   <div class="hours-box" id="sidebox-opening-hours" style="display:none;">
                    @include('businesses.openinghours')
                   </div>
                </li>
              </ul>
            </div>
        </div>
        @if (Auth::check())
          @if (($user->user))
            <p><a href="{{URL::to('partner')}}">Is this your business? Partner with us!</a></p>
          @endif
        @endif
        </div>
        <div class="col-md-8 col-sm-6 col-xs-12 p-l-0 d-flex-box business-direction">
          <div class="business-direction-map">
            {!! Mapper::render() !!}
          </div>
        </div>
    </div>
</div>
<div class="container">
  @include('businesses.menu')
</div>
<div class="cart-section">
  <div id="cart">
    @if(Auth::check())
      @if($cart && count($cart->cartitems) > 0 && $business->open)
        @include('carts.cart', ['finishPage' => false])
      @endif
    @endif
  </div>
</div>

@endsection
