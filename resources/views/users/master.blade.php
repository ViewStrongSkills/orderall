@extends('layouts.master')

@section('page-title', 'Your Account')
@section('content')
<div class="middle-contact middle-contact-account">
    <div class="container">
        <div class="account-section">
            <div class="row">
                <div class="col-sm-3">
                  <div class="setting">
                      <ul>
                        @php
                          $user = Auth::user();
                        @endphp
                          <li><a href="{{URL::to('/account')}}"><img src="{{asset('images/user-circle-o.svg')}}"/><span>My Profile<span></a></li>
                          @if(count($user->transactions) > 0)
                            <li><a href="{{URL::to('/transactions')}}"><img src="{{asset('images/food.svg')}}"/><span>My Orders<span></a></li>
                          @endif
                          @if(count($user->reviews) > 0)
                          <li><a href="{{URL::to('/account/reviews')}}"><img src="{{asset('images/file-text.svg')}}"/><span>My Reviews<span></a></li>
                          @endif
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                            @csrf
                          <li><img src="{{asset('images/sign-out.svg')}}"/><span><input type="submit" name="logout" value="Logout"><span></a></li>
                          </form>
                      </ul>
                  </div>
                </div>
                <div class="col-sm-9">
                @yield('user-content')
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
