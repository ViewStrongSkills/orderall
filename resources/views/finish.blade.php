@extends('layouts.master')

@section('page-title', 'Thanks for ordering')
@section('content')
  <div class="partner-content">
    <h3>Order complete!</h3>
    <img src="{{URL::to('images/complete-check.svg')}}">
    <p>Thank you for ordering from us! Your order has been sent to the business.
      We'll send you a confirmation when it's ready and you can pick it up. If there are any problems we'll let you know,
       otherwise we'll send you a receipt soon.</p>
  </div>
@endsection
