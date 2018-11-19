@extends('layouts.master')

@section('page-title', 'Reviews for '  . $menuitem->name)
@section('content')
  <h1>Reviews for <a href="{{route('businesses.show', $business->id)}}#{{$menuitem->id}}">{{$menuitem->name}}</a> </h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Date</th>
        <th scope="col">User</th>
        <th scope="col">Rating</th>
        <th scope="col">Content</th>
      </tr>
    </thead>
    @foreach($reviews as $review)
      <tbody>
      <tr>
        <td>{{$review->created_at}}</td>
        <td>{{$review->user->first_name . ' ' . ($review->user->last_name[0]) . '.'}}</td>
        <td>{{$review->rating}}/100</td>
        <td>{{$review->content}}</td>
      </tr>
    </tbody>
    @endforeach
  </table>
  {{ $reviews->links() }}
@endsection
