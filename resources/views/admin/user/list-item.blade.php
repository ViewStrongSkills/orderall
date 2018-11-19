@php
  $userRole = null;
  if ($user->roles->isNotEmpty()){
    $userRole = $user->roles->first()->name;
  }
@endphp

<tr>
  <td>{{$user->id}}</td>
  <td>
    @permission('admin.user.edit')
      <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a>
    @endpermission
  </td>
  <td>{{$user->email}}</td>
  <td>{{$user->first_name . ' ' . $user->last_name}}</td>
  <td>
    @include('admin.user.list-item-toggle-role')
  </td>
  <td>
    @include('admin.user.list-item-set-business')
  </td>
  <td class="delete">
    @permission('admin.user.delete')
    	<a href="{{ route('admin.user.destroy', $user->id) }}" class="btn btn-sm btn-danger delete-entry" data-model="user" data-id="{{ $user->id }}" data-title="{{ $user->name }}">x</a>
    @endpermission
  </td>
</tr>
