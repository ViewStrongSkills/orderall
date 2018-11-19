@extends('users.master')
@section('page-title', 'Your Transactions')
@section('user-content')
    <br />
    <h3>Transactions</h3>
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
            <th scope="col">Business</th>
            <th scope="col">Price</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
          <tr class="transaction" data="{{route('transactions.show', $transaction->id)}}">
            <td>
              {{$transaction->created_at->format('M d Y, H:i:s')}}
            </td>
            <td>
              {{$transaction->business->name}}
            </td>
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
@endsection
