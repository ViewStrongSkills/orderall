@extends('layouts.master')

@section('page-title', 'Add a menu')
@section('content')
  <div class="container">
    <h1>Add a new menu</h1>
    {{ Form::open(['route' => ['menus.store', $business->id], 'class' => 'menus-ajax-form']) }}

    @include('errors')
    @include('menus.form-fields')
  </div>
  <div class="modal-footer">
    {{ Form::submit('Create the Menu', array('class' => 'btn btn-primary')) }}
  </div>

  {{ Form::close() }}
  </div>
@endsection
