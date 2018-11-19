@extends('users.master')

@section('page-title', 'Your reviews')
@section('user-content')
  <br />
  <h3>Your reviews</h3>
  <script type="text/javascript">
    $(document).ready(function(){
      $('body').on('click', '.review', function(e){
        window.location = $(this).attr("data");
      })
    });
  </script>
  <style media="screen">
    .review {cursor:pointer;}
    .review:hover {color: gray;}
  </style>
  @if(count($reviews) > 0)
  <table class="table">
    <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Business</th>
      <th scope="col">Item</th>
      <th scope="col">Rating</th>
      <th scope="col">Content</th>
    </tr>
  </thead>
    @foreach($reviews as $review)
      <tbody>
        <tr class="review" data="{{URL::to('businesses/' . $review->menuitem->menu->business->id . '#' . $review->menu_item_id)}}">
          <td>{{$review->created_at}}</td>
          <td>{{$review->menuitem->menu->business->name}}</td>
          <td>{{$review->menuitem->name}}</a></td>
          <td>{{$review->rating}}/100</td>
          <td>{{$review->content}}</td>
        </tr>
      </tbody>
    @endforeach
  </table>
  {{ $reviews->links() }}
  @else
    <p>You currently do not have any reviews.</p>
  @endif
@endsection
