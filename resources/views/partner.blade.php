@extends('layouts.master')

@section('page-title', 'Partner with us!')
@section('content')
<div class="clearfix"></div>
  <div class="partner-content">
    <h3>Partner with us</h3>
    <img src="{{URL::to('images/handshake-o.svg')}}" alt="">
    <div class="search_box search_box_phone ">
      <p>Do you already have an Orderall account but you'd like to use it for a business?</p>
        <p>{{HTML::mailto('partner@orderall.io?&subject=I\'d%20like%20to%20partner%20with%20Orderall&body=Hi%20my%20name%20is', 'Email Us!', ['class' => 'btn btn-primary'])}}</p>
        <p>Otherwise, sign up for a business account at the <a href="{{URL::to('/register-business')}}">business signup</a> page.</p>
      <p>Follow the <a href="{{URL::to('/business-guide')}}">guide for businesses</a> setting up their Orderall page</p>
    </div>
  </div>
@endsection
