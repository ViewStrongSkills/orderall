@php
    $days_long = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $selected_tags = old('tags') ? old('tags') : (isset($business) ? $business->tags->pluck('name') : null);
@endphp
@include('partials.fields-required')
<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            {{ Form::label('name', 'Business Name') }}
            {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'autocomplete' => 'organization', 'placeholder' => 'Example Burger', 'maxlength' => '100')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            {{ Form::label('tags', 'Tags') }}
            {{ Form::select('tags[]', $tags, $selected_tags, ['class' => 'form-control select-tags', 'multiple'])}}
        </div>
    </div>
</div>
<hr />
<h3 class="mb-20">Location</h3>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ Form::label('addressLine1', 'Address Line 1') }}
            {{ Form::text('addressLine1', Input::old('addressLine1'), array('class' => 'form-control', 'autocomplete' => 'address-line1', 'placeholder' => 'Unit 1', 'maxlength' => '100')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            {{ Form::label('addressLine2', 'Address Line 2') }}
            {{ Form::text('addressLine2', Input::old('addressLine2'), array('class' => 'form-control', 'autocomplete' => 'address-line2', 'placeholder' => '123 Example Street', 'maxlength' => '100')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            {{ Form::label('locality', 'Locality (Town/Suburb etc)') }}
            {{ Form::text('locality', Input::old('locality'), array('class' => 'form-control', 'autocomplete' => 'address-level2', 'placeholder' => 'Examplebury', 'maxlength' => '50')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            {{ Form::label('postcode') }}
            {{ Form::text('postcode', Input::old('postcode'), array('class' => 'form-control', 'autocomplete' => 'postal-code', 'placeholder' => '1234', 'maxlength' => '4')) }}
        </div>
    </div>
</div>
<hr />
<h3 class="mb-20">Mark your business's location</h3>
  {{ Form::hidden('latitude', Input::old('latitude'), array('class' => 'form-control', 'id' => 'latitude')) }}
  {{ Form::hidden('longitude', Input::old('longitude'), array('class' => 'form-control', 'id' => 'longitude')) }}
  <div style="width: 100%; height: 500px;">
    {!! Mapper::render() !!}
  </div>
  <hr />
<h3 class="mb-20">Contact</h3>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {{ Form::label('email', 'Email Address') }}
            {{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'autocomplete' => 'email', 'placeholder' => 'exampleburger@example.com', 'maxlength' => '100')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            {{ Form::label('website') }}
            {{ Form::text('website', Input::old('website'), array('class' => 'form-control', 'placeholder' => 'http://www.example.org', 'maxlength' => '100')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
            {{ Form::label('phone', 'Phone Number (+61)') }}
            {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control', 'autocomplete' => 'tel-national', 'placeholder' => '0234567890', 'maxlength' => '50'))
          }}
        </div>
    </div>
</div>
<hr />
@include('businesses.form-operating-hours')
<hr />
<h3 class="mb-20">Business Image</h3>
<div class="form-group required">
    @include('partials.form-file', [
      'name'=>'imagedl',
      'label'=>'Business image (Maximum size 2MB, PNG, JPEG or BMP, will be cropped to 7:4)',
      'file'=>isset($business) ? $business->image_path : null,
    ])
</div>
