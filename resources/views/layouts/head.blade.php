<head>
  <meta charset="utf-8">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
  <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('android-chrome-256x256.png') }}">
  <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">
  <link rel="icon" type="image/png" sizes="150x150" href="{{ asset('mstile-150x150.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('site.webmanifest') }}">
  <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
  @stack('styles')
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="@yield('meta-description', 'Order from restaurants near you with Orderall. Search for food, choose what you want and pick it up for free.')">
  <meta name="keywords" content="@yield('meta-keywords', 'order, food, search, restaurants')">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#333">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta property="og:title" content="@yield('og-title' . ' | Orderall', 'Order from restaurants near you | Orderall')" />
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="Orderall" />
  <meta property="og:description" content="@yield('og-description', 'Order from restaurants near you with Orderall. Search for food, choose what you want and pick it up for free.')" />
  <meta property="og:url" content="{{URL::current()}}" />
  <meta property="og:image" content="@yield('og-image', asset('android-chrome-512x512.png'))" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="{{'@OrderallApp'}}" />
  <meta name="twitter:image" content="@yield('twitter-image', asset('android-chrome-512x512.png'))">
  <meta name="twitter:title" content="@yield('twitter-title' . ' | Orderall', 'Order from restaurants near you | Orderall')">
  <meta name="twitter:description" content="@yield('twitter-description', 'Order from restaurants near you with Orderall. Search for food, choose what you want and pick it up for free.')">
  <script src = "{{URL::to('js/jquery-3.3.1.min.js')}}"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script>window.Laravel = @php echo(json_encode(['csrfToken' => csrf_token()])); @endphp </script>
  <script>var baseUrl = '{{url('/')}}/';</script>
  <title>@yield('page-title', config('app.name')) | {{config('app.name')}}</title>
</head>
