@extends('layouts.master')
@section('page-title', $business->name . ' Transactions')
@section('content')
<div class="clearfix"></div>
    <div class="container">
      <h1 class="mt-40">
        Transactions /
        <a class="edit-link" href="{{route('businesses.show', $business->id)}}">{{$business->name}}</a>
      </h1>
      <script type="text/javascript">
        $(document).ready(function(){
          $('body').on('click', '.transaction', function(e){
            window.location = $(this).attr("data");
          })
        });
      </script>
      <style media="screen">
        .transaction {cursor:pointer;}
        .transaction:hover {color: gray;}
      </style>

      @if ($transactions->isNotEmpty())

        <table class="table">
          <thead>
            <tr>
              <th scope="col">Date</th>
              <th scope="col">User</th>
              <th scope="col">Price</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transactions as $transaction)
            <tr class="transaction" data="{{URL::to('/businesses/' . $business->id . '/transactions/' . $transaction->id)}}">
              <td>
                {{$transaction->created_at->format('M d Y, H:i:s')}}
              </td>
              <td>{{$transaction->user->first_name . ' ' . $transaction->user->last_name . ' (ID: ' . $transaction->user->id . ')'}}</td>
              <td>${{$transaction->price}}</td>
              @if($transaction->status == 'declined')
                <td>{{ucfirst($transaction->status) . ' (' . $transaction->declined_reason . ')'}}</td>
              @else
                <td>{{ucfirst($transaction->status)}}</td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>

        {{$transactions->links()}}
      @else
        <p>None Found</p>
      @endif

    </div>
@endsection
