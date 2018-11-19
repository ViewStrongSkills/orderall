@extends('layouts.master')

@section('page-title', 'Add a menu item')
@section('content')
  <h1>Add a new Menu Item</h1>
  @include('menuitems.form-create')
@endsection
