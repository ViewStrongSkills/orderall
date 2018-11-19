<!DOCTYPE html>
<html lang="en" dir="ltr">
@include('layouts.head')
  <body>
    @include('layouts.header')
    @include('flash::message')
    @yield('content')
    @include('layouts.footer')

    @stack('scripts')
    <script defer src = "{{URL::to('js/scripts.js')}}"></script>
    @if(Auth::check())
    <script defer src = "{{URL::to('js/notifications.js')}}"></script>
    @endif
  </body>
</html>
