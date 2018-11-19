@extends('layouts.master')

@section('page-title', 'Edit ' . $menuextracategory->name)
@section('content')
  <h1>Edit {{$menuextracategory->name}}</h1>
  @include('menuextracategories.form-edit')
@endsection
