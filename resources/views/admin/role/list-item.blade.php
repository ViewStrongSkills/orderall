<tr>
  <td class="edit">
    @permission('admin.role.edit')
    @if ($role->editable)
      <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-info btn-xs">Edit</a>
    @endif
    @endpermission
  </td>
  <td>{{$role->name}}</td>
</tr>