@extends('layouts.master')

@section('content')

    <h3 class="page-title">Create user</h3>

    {!! Form::open([
      'files' => true, 
      'url' => route('admin.user.store'), 
      'method' => 'post',
      'class' => ''
      ]) !!}

      {{Form::text('first_name', null, ['name' => 'first_name', 'placeholder' => 'first name'])}}
      {{Form::text('last_name', null, ['name' => 'last_name', 'placeholder' => 'last name'])}}
      {{Form::text('email', null, ['name' => 'email', 'placeholder' => 'Email'])}}
      {{Form::text('business_id', null, ['name' => 'business_id', 'placeholder' => 'Business ID'])}}
      {{Form::select('role', $roles, null, ['placeholder' => 'Select role...'])}}
      {{Form::password('Password', ['name' => 'password', 'placeholder' => 'Password'])}}
      {{Form::password('Password confirmation', ['name' => 'password_confirmation', 'placeholder' => 'Password Confirmation'])}}

      {{Form::submit('Create', ['class' => 'btn btn-success pull-right']) }}

    {!! Form::close() !!}

@endsection
