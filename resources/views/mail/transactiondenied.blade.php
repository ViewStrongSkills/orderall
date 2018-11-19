@extends('mail.layouts.master')
@section('page-title', 'Transaction Denied')
@section('content')
<table align="center" width="600">
	<tbody>
		<tr>
			<td>
				<h1>Transaction denied</h1>
				<p style="color: #5a5a5a;">Unfortunately your transaction has been declined by the business.
			    @if ($reason)
			      The reason given was {{$reason}}.
			    @else
			      There was no reason given.
			    @endif
			    </p>
				<p style="color: #5a5a5a;">All your transactions can be viewed from 
					<a href="{{URL::to('/transactions')}}">your account page</a>.
				</p>
		    </td>
		</tr>
	</tbody>
</table>
@endsection
