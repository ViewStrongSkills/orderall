@extends('users.master')
@section('page-title', 'Transaction for ' . $transaction->business->name . ' at ' . $transaction->created_at->format('M d Y, H:i:s'))
@section('user-content')
  <br />
    <div>
      <h3>
        <a href="{{URL::to('/transactions')}}">Transactions</a> / {{$transaction->created_at->format('M d Y, H:i:s')}}
      </h3>

      <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th></th>
            <th scope="col">Price</th>
            <th scope="col">Review</th>
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
              @if($transaction->status == 'accepted' && $item->item)
                @if (!($item->item->reviews->contains('user_id', Auth::user()->id)))
                  <td><a href="{{URL::to('/businesses/' . $item->item->menu->business->id . '/menuitems/' . $item->item->id . '/reviews/create')}}">Add Review</a></td>
                @endif
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
            <th scope="col">Business</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$transaction->created_at->format('M d Y, H:i:s')}}</td>
            <td><a href="{{URL::to('/businesses/' . $transaction->business->id)}}">{{$transaction->business->name}}</a></td>
            <td>${{$transaction->price}}</td>
            @if($transaction->status == 'declined')
              <td>{{ucfirst($transaction->status) . ' (' . $transaction->declined_reason . ')'}}</td>
            @else
              <td>{{ucfirst($transaction->status)}}</td>
            @endif
          </tr>
        </tbody>
      </table>
    </div>
@endsection
