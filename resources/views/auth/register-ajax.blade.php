<div class="right">
    <ul class="custom_tab">
      <li id="login" class="logreg"><a href="{{ url('login') }}"><img alt="" src="{{ asset('images/user-o.svg') }}"> LOGIN</a></li>
      <li id="register" class="active logreg"><a href="#"><img alt="" src="{{ asset('images/edit.svg') }}"> REGISTER</a></li>
      <li id="business-register" class="logreg"><a href="{{ url('register-business') }}"><img alt="" src="{{ asset('images/suitcase.svg') }}"> BUSINESS</a></li>
    </ul>
    <div class="tab-content">

      <div class="tab-pane mt20 fade in active">
          <form method="POST" action="{{ route('register') }}">
              @csrf
              @if ($errors->has('ip'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('ip') }}</strong>
                </span>
              @endif
              <div class="form-group">
                  <input id="first_name" autocomplete="given-name" type="text" placeholder="{{ __('First Name') }}" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
                  @if ($errors->has('first_name'))
                      <span class="invalid-feedback">
                          <strong>{{ $errors->first('first_name') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="form-group">
                  <input id="last_name" autocomplete="family-name" type="text" placeholder="{{ __('Last Name') }}" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                  @if ($errors->has('last_name'))
                      <span class="invalid-feedback">
                          <strong>{{ $errors->first('last_name') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="form-group">
                  <input id="email" autocomplete="email" type="email" placeholder="{{ __('Email Address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                  @if ($errors->has('email'))
                      <span class="invalid-feedback">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-group">

                  <input id="password" autocomplete="new-password" type="password" placeholder="{{ __('Password') }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                  @if ($errors->has('password'))
                      <span class="invalid-feedback">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="form-group mb10">
                  <input id="password-confirm" autocomplete="new-password" type="password" placeholder="{{ __('Confirm Password') }}" class="form-control" name="password_confirmation" required>
              </div>
              <div class="form-group">
                @if ($errors->has('tos'))
                    <span class="invalid-feedback">
                        <strong>You must agree to the terms of service and privacy policy</strong>
                    </span>
                @endif
                  <label class="custom_check_box">
                  <input name="tos" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                  <span></span>
                  <input type="checkbox" >I agree to the <a target="_blank" href="{{URL::to('tos')}}">Terms of Service</a> and <a target="_blank" href="{{URL::to('privacy')}}">Privacy Policy</a>
                  </label>
              </div>

              <div class="form-group text-center pt5 mb0">
              <input type="submit" class="button01" value="Sign up" name="">
              </div>
          </form>

      </div>


    </div>
  </div>
