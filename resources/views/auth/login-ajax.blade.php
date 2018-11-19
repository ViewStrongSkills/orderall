<div class="right">
    <ul class="custom_tab">
        <li id="login" class="active logreg"><a href="#"><img alt="" src="{{ asset('images/user-o.svg') }}"> LOGIN</a></li>
        <li id="register" class="logreg"><a  href="{{ url('register') }}"><img alt="" src="{{ asset('images/edit.svg') }}"> REGISTER</a></li>
        <li id="business-register" class="logreg"><a href="{{ url('register-business') }}"><img alt="" src="{{ asset('images/suitcase.svg') }}"> BUSINESS</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active mt40 pb5">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input id="email" autocomplete="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group mb10">
                    <input id="password" autocomplete="current-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Password') }}">
                    @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="custom_check_box">
                    <input name="" type="checkbox" id="visible-checkbox" {{ old('remember') ? 'checked' : '' }} onchange="$('#remember').prop('checked', $('#visible-checkbox').is(':checked'));" >
                    <span></span>
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>
                    <a href="{{ route('password.request') }}" class="link logreg" id="password/reset">{{ __('Forgot Your Password?') }}</a>
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="button01" value=" {{ __('Login') }}" name="">
                </div>

            </form>

            <div class="account_link pt5">
            Don’t have an account? <a class="logreg" href="{{URL::to('register')}}">Signup</a>
            </div>
        </div>

    </div>
</div>
