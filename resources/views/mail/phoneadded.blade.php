@extends('mail.layouts.master')

@section('page-title', 'A phone number has been added to your account')
@section('content')
<table align="center" width="600">
	<tbody>
		<tr>
			<td>
			    <h1>Phone number added</h1>
			    <p style="color: #5a5a5a;">Hi, this an email to confirm that you've added a phone number to your account.</p>
			    <p style="color: #5a5a5a;"><strong style="color: #000;">Regards,</strong>
			    	<br>the {{config('app.name')}} team</p>
    		</td>
		</tr>
	</tbody>
</table>			    	
@endsection
