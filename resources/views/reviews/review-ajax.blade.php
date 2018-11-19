<div class="modal-body">
  @if($menuitem->image_path)
    <img width="100%" src="{{asset('storage/images/menuitems/'.$menuitem->image_path . '.png') }}">
  @else
    <img width="100%" src="{{asset('images/default.svg')}}" alt="">
  @endif
  <h3>Reviews for {{$menuitem->name}}</h3>
  <table class="table">
    @foreach($reviews as $review)
      <tbody>
      <tr>
        <td>{{$review->user->first_name . ' ' . ($review->user->last_name[0]) . '.'}}</td>
        <td title="{{$review->created_at}} AEST">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->created_at)->diffForHumans()}}</td>
        <td>{{$review->rating}}/100</td>
      </tr>
    </tbody>
    <tr>
      <td colspan="6">
        {{$review->content}}
      </td>
    </tr>
    @endforeach
  </table>
</div>
