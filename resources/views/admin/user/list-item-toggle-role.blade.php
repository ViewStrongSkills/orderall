@if (Auth::user()->can('admin.user.toggle-role'))
  @foreach ($roles as $role)
    @if ($role->name == $userRole)
      <span class="btn btn-sm btn-outline-primary">{{$role->name}}</span>
    @else
      <a href="{{route('admin.user.toggle-role', ['user' => $user->id, 'user_id' => $user->id, 'role_id' => $role->id])}}" class="btn btn-sm btn-outline-secondary">Set {{$role->name}}</a>
    @endif
  @endforeach
@else
  @if ($userRole)
    {{$userRole}}
  @else
    N/a
  @endif
@endif