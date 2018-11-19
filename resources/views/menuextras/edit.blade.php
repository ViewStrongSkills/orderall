@extends('layouts.master')

@section('page-title', 'Edit ' . $menuextra->name)
@section('content')
        <h1>Edit {{$menuextra->name}}</h1>
        @include('errors')
        {{ Form::model($menuextra, ['route' => ['menuextras.update', $business->id, $menuitem->id, $menuextra->id], 'method' => 'PUT']) }}
        @include('menuextras.form-fields')
        {{ Form::submit('Edit ' . $menuextra->name, array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
@endsection
