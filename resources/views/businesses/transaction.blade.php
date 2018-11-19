@extends('layouts.master')
@section('page-title', 'Transaction for ' . $transaction->user->first_name . ' ' . $transaction->user->last_name . ' at ' . $transaction->created_at->format('M d Y, H:i:s'))
@section('content')
<div class="clearfix"></div>
    <div class="container">
      <h1 class="mt-40">
        <a class="edit-link" href="{{route('businesses.transactions', $transaction->business_id)}}">Transactions</a> / {{$transaction->created_at->format('M d Y, H:i:s')}}
      </h1>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th></th>
            <th scope="col">Price</th>
          </tr>
        </thead>
        <tbody>
          @if($transaction->items->isNotEmpty())
            @foreach($transaction->items as $item)
            <tr>
              <td><b>{{$item->name}}</b></td>
              <td></td>
              @if($item->discount)
              <td>${{number_format($item->current_price, 2)}}</td>
              @else
              <td>${{$item->price}}</td>
              @endif
            </tr>
            @if($item->extras->isNotEmpty())
              @foreach($item->extras as $extra)
              <tr>
                <td><i>+{{$extra->name}}</i></td>
                <td></td>
                <td>${{$extra->price}}</td>
              </tr>
              @endforeach
            @endif
            @endforeach
          @endif
        </tbody>
        <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">User</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$transaction->created_at->format('M d Y, H:i:s')}}</td>
            <td>{{$transaction->user->first_name . ' ' . $transaction->user->last_name . ' (ID: ' . $transaction->user->id . ')'}}</td>
            <td>${{$transaction->price}}</td>
            @if($transaction->status == 'declined')
              <td>{{ucfirst($transaction->status) . ' (' . $transaction->declined_reason . ')'}}</td>
            @else
              <td>{{ucfirst($transaction->status)}}</td>
            @endif          </tr>
        </tbody>
      </table>

    </div>
@endsection
