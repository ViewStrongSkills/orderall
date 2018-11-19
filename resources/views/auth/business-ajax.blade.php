<div class="right">
  <ul class="custom_tab">
    <li id="login" class="logreg"><a href="{{ url('login') }}"><img alt="" src="{{ asset('images/user-o.svg') }}"> LOGIN</a></li>
    <li id="register" class="logreg"><a href="{{ url('register') }}"><img alt="" src="{{ asset('images/edit.svg') }}"> REGISTER</a></li>
    <li id="business-register" class="active logreg"><a href="{{ url('#') }}"><img alt="" src="{{ asset('images/suitcase.svg') }}"> BUSINESS</a></li>
  </ul>
    <div class="tab-content">
      <style media="screen">
        .invalid-feedback {color: red;}
      </style>

     <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
    </style>

      <div class="tab-pane mt20 fade in active">
          <form method="POST" enctype="multipart/form-data" id="business" action="{{ route('register-business') }}">
              @csrf
              <label>Follow the <a href="{{URL::to('business-guide')}}">setup guide</a> for businesses to get up and running with Orderall</label>
              <div class="form-group">
                  <input id="first_name" autocomplete="given-name" type="text" placeholder="{{ __('First Name') }}" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
                  <span class="help-block"><strong></strong></span>
              </div>
              <div class="form-group">
                  <input id="last_name" autocomplete="family-name" type="text" placeholder="{{ __('Last Name') }}" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                  <span class="help-block"><strong></strong></span>
              </div>
              <div class="form-group">
                  <input id="email" autocomplete="email" type="email" placeholder="{{ __('Email Address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                  <span class="help-block"><strong></strong></span>
              </div>

              <div class="form-group">
                  <input id="password" autocomplete="new-password" type="password" placeholder="{{ __('Password') }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                  <span class="help-block"><strong></strong></span>
              </div>
              <div class="form-group mb10">
                  <input id="password-confirm" autocomplete="new-password" type="password" placeholder="{{ __('Confirm Password') }}" class="form-control" name="password_confirmation" required>
                  <span class="help-block"><strong></strong></span>
              </div>
              <div class="form-group">
                  <input id="business-name" autocomplete="business-name" type="text" placeholder="{{ __('Business Name') }}" class="form-control{{ $errors->has('business-name') ? ' is-invalid' : '' }}" name="business_name" value="{{ old('business_name') }}" required>
                  <span class="help-block"><strong></strong></span>
              </div>

              <div class="form-group">
                <label>We need evidence that shows that you own or run the business. This can be any file under two megabytes.</label>
                <label><a href="{{URL::to('/business-evidence')}}" target="_blank">What qualifies as evidence?</a></label>
                    <div class="field image-upload">
                        <div class="form-group">
                            <label class="btn btn-default btn-file" style="width:100%;background-color: #f37620; border-color: #f16721;">
                            <span id="choose-filename">Upload business ownership evidence</span>
                            </label>
                            <input name="business-evidence" id="field-business-evidence" type="file" class="form-control"><br/>
                            <div class="progress ">
                                <div class="bar"></div >
                                <div class="percent">0%</div >
                            </div>
                        </div>
                    </div>
                <span id="business-evidence-error" class="help-block"><strong></strong></span>
                </div>
                <div class="form-group">
                    <label class="custom_check_box">
                    <input name="tos" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    <span></span>
                    <input type="checkbox" >I agree to the <a target="_blank" href="{{URL::to('tos')}}">Terms of Service</a>, <a target="_blank" href="{{URL::to('business-tos')}}">Terms of Service for Businesses</a> and <a target="_blank" href="{{URL::to('privacy')}}">Privacy Policy</a>
                    </label>
                    <span id="tos-error" class="help-block"><strong></strong></span>
                </div>

               <div class="form-group text-center pt5 mb0">
                    <input type="submit" class="button01" value="Sign up" name="">
              </div>
          </form>

      </div>
    </div>
  </div>
<style>
#field-business-evidence {
    margin-top: -35px;
    opacity: 0;
}
.progress {
    display: none;
}
</style>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('.progress').css('display','block');

            if (fileName) {
              $('#choose-filename').text(fileName);
            }
            else
            {
              $('#choose-filename').text('Choose File');
            }
        });
    });


    function validate(formData, jqForm, options)
    {
        var form = jqForm[0];
        var posterValue = $('input[name=business-evidence]').fieldValue();
        if (!posterValue) {
            return false;
        }
    }

    (function()
    {

    var bar = $('.bar');
    var percent = $('.percent');

    $('form').ajaxForm({
        beforeSubmit: validate,
        beforeSend: function() {
            var percentVal = '0%';
            var posterValue = $('input[name=business-evidence]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function(resp) {
            var percentVal = 'Wait, Saving';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        error: function (resp) {
           if( resp.status === 422 ) {
               var message = $.parseJSON(resp.responseText);
               $.each(message.errors, function (key, val) {
                   var input = '#business input[name=' + key + ']';
                   $(input + '+span>strong').text(val);
                   $(input).parent().parent().addClass('has-error');
                   if (key == 'tos') {
                       $('#tos-error').text(val);
                   }
                   if (key == 'business-evidence') {
                       $('#business-evidence-error').text(val);
                   }
               });
           }
        },
        complete: function(xhr) {
            if (xhr.status == 200) {
                window.location.href = "/";
            }
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
    });

    })();
</script>
