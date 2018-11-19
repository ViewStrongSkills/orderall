@extends('mail.layouts.master')

@section('page-title', 'Permission Changed')
@section('content')
    <table align="center" width="600">
  		<tbody>
  			<tr>
  				<td>
					<h1>Permission level changed</h1>
					<p style="color: #5a5a5a;">Hi <strong style="color: #000;">{{$user->first_name}},</strong></p>
          @if ($user->roles()->first()->name)
            <p style="color: #5a5a5a;">Congratulations! Your application has been accepted, and you can now add your business.</p>
          @else
            <p style="color: #5a5a5a;">We have changed your permissions. You are now a {{$user->roles()->first()->name}}.</p>
          @endif
					<p style="color: #5a5a5a;"><strong style="color: #000;">Regards,</strong>
					<br>the Orderall team</p>
				</td>
			</tr>
  		</tbody>
	</table>
@endsection
