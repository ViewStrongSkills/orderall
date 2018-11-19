@extends('auth.master')

@section('page-title', 'Reset Password')

@section('content')
  <div class="right">
    <ul class="custom_tab">
        <li id="login" class="logreg"><a href="{{ url('login') }}"><img src="{{ asset('images/user-o.svg') }}"> LOGIN</a></li>
        <li id="register" class="logreg"><a  href="{{ url('register') }}"><img src="{{ asset('images/edit.svg') }}"> REGISTER</a></li>
    </ul>
    <div class="tab-content">

        <h2>Reset password</h2>
        <div class="tab-pane fade in active mt40 pb5">
          <form method="POST" action="{{ route('password.request') }}">
          @csrf
          @include('errors')
          <div class="form-group">
            <input type="hidden" name="token" value="{{ $token }}">
                  <input id="email" placeholder="Email Address" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
          </div>
          <div class="form-group">
                  <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
          </div>
          <div class="form-group">
                  <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>
          </div>
          <div class="form-group text-center pt5 mb0">
                  <button type="submit" class="button01">
                      Reset
                  </button>
          </div>
      </form>
    </div>
  </div>
  </div>
@endsection
