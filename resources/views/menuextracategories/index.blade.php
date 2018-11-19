@extends('layouts.master')

@section('page-title', 'Manage menu extra categories for ' . $menuitem->name)
@section('content')
<div class="clearfix"></div>
<div class="container">
    <h1 class="mt-40">Manage <a class="edit-link" href="{{URL::to('/businesses/' . $business->id . '/menuitems/' . $menuitem->id . '/menuextras')}}">menu extra</a> categories for <a class="edit-link" href="{{URL::to('/businesses/' . $business->id . '#' . $menuitem->id)}}">{{$menuitem->name}}</a></h1>
    <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Required</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="menuextracategories">
          @foreach($menuitem->extracategories as $category)
            @include('menuextracategories.list-item')
          @endforeach
          @include('menuextracategories.index-create')
        </tbody>
    </table>
    @include('errors')
</div>
@endsection
