@extends('layouts.master')

@section('page-title', 'Edit ' . $menuitem->name)
@section('content')
  <h1>Edit {{$menuitem->name}}</h1>
	@include('menuitems.form-edit')
@endsection
