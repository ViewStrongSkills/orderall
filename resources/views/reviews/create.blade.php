@extends('users.master')

@section('page-title', 'Review '  . $menuitem->name)
@section('user-content')
  <h1>Review  <a href="{{URL::to('/businesses/' . $menuitem->menu->business->id . '#' . $menuitem->id)}}">{{$menuitem->name}}</a></h1>
    @include('errors')
    @include('partials.fields-required')
    @include('reviews.create-form-fields')
@endsection
