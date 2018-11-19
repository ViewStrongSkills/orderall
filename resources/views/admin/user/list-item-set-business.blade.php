@if (Auth::user()->can('admin.user.set-business'))
  @if (Auth::user()->hasRole('Developer') && $user->hasRole('Business'))
    <form action="{{route('admin.user.set-business', $user->id)}}" method="get">
      <input style="width:3em" type="text" name="business_id" placeholder="ID" value="{{$user->business_id}}">
      <button class="btn btn-sm btn-outline-secondary">Set</button>
    </form>   
    @if ($user->business)
      <strong>{{ $user->business->name }}</strong>
    @endif
  @else
    N/a
  @endif 
@else

  @if ($user->business)
    <strong>{{ $user->business->name }}</strong>
  @else
    N/a
  @endif 

@endif