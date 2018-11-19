@extends('layouts.master')

@section('content')
<div class="clearfix"></div>
<div class="container">
  <h1 class="mt-40 mb-20">Search Users by Email</h1>

  <form class="" action="{{route('admin.user.index')}}" method="GET">
    <div class="form-group">
      <input id="search" autocomplete="off" class="form-control" type="text" name="search" value="{{request()->search}}" placeholder="Search for users" required>
    </div>
  </form>

  @permission('admin.user.create')
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-20">Create User</a>
  @endpermission

  @if (request()->has('search'))

    @if ($users->isNotEmpty())
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th></th>
            <th>E-mail</th>
            <th>Name</th>
            <th>Role</th>
            <th>Business</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            @include('admin.user.list-item', ['roles' => $roles])
          @endforeach
          {{-- @each ('admin.user.list-item', $users, 'user', 'admin.user.list-empty')         --}}
        </tbody>
      </table>

      {{ $users->links() }}  

    @else
      <p>None Found</p>
    @endif

  @endif

</div>
@endsection