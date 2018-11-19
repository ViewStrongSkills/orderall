@extends('layouts.master')

@section('content')
<div class="clearfix"></div>
<div class="container">
  <div class="mb-20 mt-40">
  @permission('admin.role.create')
    <a href="{{ route('admin.role.create') }}" class="btn btn-primary mr-1">Create Role</a>
  @endpermission
  
  @if (Auth::user()->developer)
    <a href="{{ route('admin.role.update-developer-permissions') }}" class="btn btn-primary float-sm-right">Update Developer Permissions</a>
  @endif
  </div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th>
        <th>Title</th>
      </tr>
    </thead>
    <tbody>
    	@each ('admin.role.list-item', $roles, 'role', 'admin.role.list-empty')
    </tbody>
  </table>
</div>
@endsection
