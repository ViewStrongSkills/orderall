@extends('layouts.master')

@section('content')

    <h3>{{ $user->name}}</h3>

    {!! Form::model($user, [
      'files' => true, 
      'url' => route('admin.user.update', $user->id), 
      'method' => 'patch',
      'class' => 'form-horizontal form-label-left'
      ]) !!}

      {{ Form::text('first_name', null, ['name' => 'first_name', 'placeholder' => 'first name'])}}
      {{ Form::text('last_name', null, ['name' => 'last_name', 'placeholder' => 'last name'])}}
      {{ Form::text('email', null, ['name' => 'email', 'placeholder' => 'Email'])}}
      {{ Form::text('business_id', null, ['name' => 'business_id', 'placeholder' => 'Business ID'])}}
      {{ Form::select('role', $roles, $user->roles, ['placeholder' => 'Select role...'])}}

      {{Form::password('password', ['name' => 'password', 'placeholder' => 'New Password'])}}
      {{Form::password('password_confirmation', ['name' => 'password_confirmation', 'placeholder' => 'Password Confirmation'])}}
      {{Form::password('current_user_password', ['name' => 'current_user_password', 'placeholder' => 'Your Current Password'])}}


      @if (Auth::user()->can('admin.user.delete'))
        {{ Form::button('Delete', ['class' => 'btn btn-danger delete-entry', 'data-model' => 'user', 'data-id' => $user->id, 'data-title' => $user->name]) }}
      @endif

      @if (Auth::user()->can('admin.user.edit'))
        {{ Form::submit('Save', ['class' => 'btn btn-success pull-right']) }}
      @endif


    {!! Form::close() !!}



@endsection
