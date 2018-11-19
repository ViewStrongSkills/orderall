@extends('layouts.master')

@section('page-title', 'Order from restaurants near you')
@section('content')
<div class="how_it_works">
  <div class="container">
    <h1 class="title">How Orderall works</h1>
  <div class="row">
    <div class="col-sm-3">
      <div class="works_box">
        <span>1</span>
        <div class="clearfix"></div>
        <img src="{{ asset('images/image_1.svg')}}" alt="Create account">
        <h6>Create an account</h6>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="works_box">
        <span>2</span>
        <div class="clearfix"></div>
        <img src="{{ asset('images/image_2.svg') }}" alt="Search restaurants">
        <h6>Search for a <br />nearby restaurant</h6>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="works_box">
        <span>3</span>
        <div class="clearfix"></div>
        <img src="{{ asset('images/image_3.svg') }}" alt="Add to cart">
        <h6>Add whatever you <br />like to your cart</h6>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="works_box">
        <span>4</span>
        <div class="clearfix"></div>
        <img src="{{ asset('images/image_4.svg') }}" alt="Confirm order">
        <h6>Confirm your order, <br />pay and pick it up</h6>
      </div>
    </div>
  </div>
  </div>
</div>
@push('scripts')
  @if ($unsupported)
    @include('countrywarning.script-country-warning')
  @endif
  <script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Organization",
    "name": "Orderall",
    "logo": "{{asset('android-chrome-512x512.png')}}",
    "url": "https://www.orderall.io",
    "sameAs": [
      "http://www.twitter.com/OrderallApp"
    ]
  }
  </script>
@endpush
@endsection
