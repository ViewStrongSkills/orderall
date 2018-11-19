@extends('mail.layouts.master')

@section('page-title', 'Transaction Confirmed')
@section('content')
<table align="center" width="600">
    <tbody>
        <tr>
            <td>
                <h1>Transaction confirmed</h1>
                <p style="color: #5a5a5a;">Hi <strong style="color: #000;">{{$transaction->user->first_name}},</strong></p>
                <p style="color: #5a5a5a;">This is a receipt for your latest order from {{$transaction->business->name}} via {{config('app.name')}}.</p>
                <table cellpadding="8" border="1">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                    @foreach($transaction->items as $key => $transactionitem)
                    <tr>
                        <td>{{$transactionitem->item->name}}</td>
                        <td>${{$transactionitem->item->price}}</td>
                    </tr>
                        @foreach($transactionitem->extras as $key => $transactionextra)
                        <tr>
                            <td>{{$transactionextra->name}}</td>
                            <td>${{$transactionextra->price}}</td>
                        </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <th>Total:</th>
                        <td><strong>${{number_format(($transaction->price), 2)}}</strong></td>
                    </tr>
                </table>
                <p style="color: #5a5a5a;">All your transactions can be viewed from <a href="{{URL::to('/transactions')}}">your account page</a>, and you can also add a review to your order from there.</p>
                <p style="color: #5a5a5a;"><strong style="color: #000;">Regards,</strong>
                    <br>the {{config('app.name')}} team</p>
            </td>
        </tr>
    </tbody>
</table>
@endsection
