@extends('layouts.master')

@section('page-title', 'Contact Us')
@section('content')
    <div class="middle-contact">
<div class="container">
<div class="page-head-content">
<h2>Contact Us</h2>
</div>
<div class="contact-wrapper">
<div class="row">
  @include('errors')
<div class="col-sm-6">
  {{ Form::open(array('url' => '/contact/send')) }}
  <div class="form-group form-group-custom">

    <input type="text" required maxlength="200" autocomplete="given-name" class="form-control" name="first_name" placeholder="First Name">
  </div>
  </div>
  <div class="col-sm-6">
  <div class="form-group form-group-custom">

    <input type="text" required maxlength="200" autocomplete="family-name" class="form-control" name="last_name" placeholder="Last Name">
  </div>
  </div>

 </div>
 <div class="row">
<div class="col-sm-6">
  <div class="form-group form-group-custom">

    <input type="text" required maxlength="200" autocomplete="off" class="form-control" name="subject" placeholder="Subject">
  </div>
  </div>
  <div class="col-sm-6">
  <div class="form-group form-group-custom">

    <input type="email" maxlength="100" required autocomplete="email" class="form-control" name="email" placeholder="Email Address">
  </div>
  </div>

 </div>

 <div class="row">
<div class="col-sm-12">
  <div class="form-group form-group-custom">


	<textarea class="form-control" maxlength="5000" required name="content" placeholder="Message"></textarea>
  </div>
  </div>


 </div>

 <div class="row">
 <div class="col-sm-12 text-center">
 <input class="button01" value="Submit" name="submit" type="submit">
 {{ Form::close() }}
 </div>
 </div>

</div>
</div>
</div>
@endsection
