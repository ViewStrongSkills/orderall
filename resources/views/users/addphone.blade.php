@extends('users.master')
@section('page-title', 'Add a mobile phone number')
@section('user-content')
		<div class="partner-content">
			<h3>Add Phone Number</h3>
			<p>Add a phone number to your account<br/>
			so you can get updates about your order by text</p>
			<img src="{{URL::to('images/setphone.svg')}}">
			<div class="search_box search_box_phone ">
				{{ Form::open(array('url' => 'updatephone')) }}
				@include('errors')
  				{{ Form::tel('phone', Input::old('phone'), array('class' => 'form-control', 'maxlength' => '50')) }}
			    {{ Form::submit('Add phone number', array('class' => 'button01 button02')) }}
				{{ Form::close() }}
			</div>
		</div>
@endsection
