<div class="right">
  <ul class="custom_tab">
    <li id="login" class="logreg"><a href="{{ url('login') }}"><img src="{{ asset('images/user-o.svg') }}"> LOGIN</a></li>
    <li id="register" class="logreg"><a  href="{{ url('register') }}"><img src="{{ asset('images/edit.svg') }}"> REGISTER</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade in active mt40 pb5">
      @include('errors')
      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group mb10">
          <input id="email" placeholder="Email Address" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group text-center">
          <input type="submit" class="button01" value="Send link" name="">
        </div>
      </form>
    </div>
  </div>
</div>
