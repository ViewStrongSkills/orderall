@extends('layouts.master')

@section('page-title', 'Help')
@section('content')
<div class="middle-contact">
<div class="container">
<div class="page-head-content">
<h2>Help</h2>
</div>
<div class="static-content static-content-help">
<div class="privacy-content">
<h5>How does {{config('app.name')}} work?</h5>
<p>{{config('app.name')}} works like this: First you create an account, then you search for restaurants that are near you. Add items
      to your cart and click the confirm button, make sure that everything you were looking for is correct and press the finish button. Your order
      will be received by the business, which can then choose to confirm or deny the request. When we get a response from them (usually in less
      than a minute) we will send you their response. After that, you can just go and pick up your food!</p>
</div>

<div class="privacy-content">
<h5>Frequently Asked Questions</h5>
<h5>I run a business and I would like to manage it on Orderall</h5>
<p>You should create an account and then go to <a href="{{URL::to('partner')}}">the partner page</a>, and get your business set up.</p>
<h5>I want to unsubscribe from Orderall emails</h5>
<p>Sure. Just click <a href="{{URL::to('unsubscribe')}}">here</a> and you'll be taken off our email list.</p>
</div>
<div class="mt50"></div>
</div>


</div>
</div>
@endsection
