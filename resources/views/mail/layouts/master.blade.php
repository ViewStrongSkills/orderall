<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>@yield('page-title')</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <style type="text/css">
      body{font-family: 'Open Sans', sans-serif;font-size: 15px;}
    </style>
  </head>
  <body>
  	<table align="center" width="600">
  		<tbody>
  			<tr>
  				<td>
				    @include('mail.layouts.header')
				    @yield('content')
				    @include('mail.layouts.footer')
				</td>
			</tr>
  		</tbody>
	</table>
  </body>
</html>
