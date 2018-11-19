@extends('mail.layouts.master')

@section('page-title', 'Confirm your account')
@section('content')
<table align="center" width="600">
	<tbody>
		<tr>
			<td>
			    <h1>Confirm your account</h1>
			    <p style="color: #5a5a5a;">Hi <strong style="color: #000;">{{$user->first_name}},</strong></p>
			    <p style="color: #5a5a5a;">Please <a href="{{URL::to('/confirmaccount/' . $user->email_token)}}">click here</a> to verify your account.</p>
			    <p style="color: #5a5a5a;"><strong style="color: #000;">Regards,</strong>
			    	<br>the {{config('app.name')}} team</p>
    		</td>
		</tr>
	</tbody>
</table>
@endsection
