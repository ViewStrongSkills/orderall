@extends('layouts.master')

@section('page-title', 'Manage menu extras')
@section('content')
<div class="clearfix"></div>
    <div class="container">
        <h1 class="mt-40">Manage menu extras for 
            <a class="edit-link" href="{{URL::to('/businesses/' . $business->id . '#' . $menuitem->id)}}">{{$menuitem->name}}</a></h1>
        @include('errors')
        <a class="btn btn-large btn-outline-primary openbutton menuextracategories-index" href="{{route('menuextracategories.index', [$business->id, $menuitem->id])}}">Manage menu extra categories</a>
        <table class="table table-striped table-bordered mt-40">
          <thead>
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Category</th>
              <th>Actions</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="menuextras">
            @foreach ($menuextras as $extra)
              @include('menuextras.list-item')
            @endforeach
            @include('menuextras.index-create')
          </tbody>
        </table>
    </div>
@endsection
