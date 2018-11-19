@extends('layouts.master')

@section('page-title', 'Edit menu ' . $menu->name)
@section('content')
  <div class="container">
    <h1>Edit menu {{$menu->name}}</h1>
    @if(!$menu->main)
      @include('partials.button-delete', ['model'=> $menu, 'route'=> ['menus.destroy', $business->id, $menu->id], 'text' => 'Delete menu'])
    @endif
    {{ Form::model($menu, ['route' => ['menus.update', $business->id, $menu->id],
      'method' => 'PUT', 'class' => 'menus-ajax-form']) }}
      @include('errors')
      @include('menus.form-fields')
      <div class="modal-footer">
        {{ Form::submit('Edit ' . $menu->name, ['class' => 'btn btn-primary']) }}
      </div>
      {{ Form::close() }}
  </div>
@endsection
