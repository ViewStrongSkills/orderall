@php
  $user = Auth::user();
@endphp

<div data-fullsize="{{URL::to('/images/back_img01.jpg')}}" class="progressive-bg top_banner">
  <div class="container">
    <div class="top_navi">
        @if (Auth::check())

        <div class="dropdown pull-right dropdown-session">
          <a title="Accounts" data-target="" href="{{route('account.index')}}" data-toggle="dropdown" class="dropdown-toggle">
          <img alt="Profile" src="{{asset('images/user-circle-o-white.svg')}}" style="user-drag: none;user-select: none;-moz-user-select: none;-webkit-user-drag: none;-webkit-user-select: none;-ms-user-select: none;" class="mr10">{{$user->name}} <b class="caret"></b></a>
          <ul class="dropdown-menu">
              <li><a title="Profile" href="{{route('account.index')}}">Profile</a></li>

              @if ($user->business)
                <li><a title="Your business" href="{{route('businesses.show', $user->business_id)}}">View my business</a></li>

              @elseif ($user->canCreateBusiness())
                <li><a title="Create business" href="{{route('businesses.create')}}">Add my business</a></li>
              @endif

              @if ($user->hasRole(['Admin', 'Developer']))
                <li><a title="Users" href="{{route('admin.user.index')}}">Users</a></li>
              @endif

              @if ($user->hasRole(['Admin', 'Developer']))
                <li><a title="Roles" href="{{URL::to('/admin/role')}}">Roles</a></li>
              @endif

              <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                @csrf
              <li><input type="submit" name="logout" value="Logout"></li>
              </form>
          </ul>
        </div>

        @else
        <ul class="navi">
          <li><a title="Login" href="{{route('login')}}">Login</a></li>
          <li><a title="Register" href="{{route('register')}}">Signup</a></li>
          <li><a title="Register as Business" href="{{url('register-business')}}">Business Signup</a></li>
        </ul>
        @endif

    </div>
    <center class="test">
      <div class="banner_box">
        <a title="Orderall" href="{{route('main')}}" class="logo"><img src="{{ asset('images/logo-white-beta.svg') }}" alt="The {{config('app.name')}} logo"></a>
        <h6>Search for nearby restaurants, cafes and bars</h6>
        <div id="search-form-container">

        </div>
        <div class="search_box">
          <form class="form" id="searchform" action="#" method="GET">
          <img class="search-location" title="Get my location" alt="Get location" src="{{ asset('images/crosshairs.svg') }}" onload="if(sessionStorage.xcoord)$(this).hide()" onclick="autoGeoMethod()" style="cursor: pointer;user-drag: none;user-select: none;-moz-user-select: none;-webkit-user-drag: none;-webkit-user-select: none;-ms-user-select: none;">
          <img class="remove-search" title="Clear my location" alt="Clear location" src="{{ asset('images/cancel-location.svg') }}" onload="if(!(sessionStorage.xcoord))$(this).hide()" onclick="addressMethod()" style="cursor: pointer;user-drag: none;user-select: none;-moz-user-select: none;-webkit-user-drag: none;-webkit-user-select: none;-ms-user-select: none;">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="radius" id="search-radius" value="{{ (isset($radius) ? $radius : 10) }}">
            {{ Form::hidden('xcoord', '0', array('id' => 'xcoord')) }}
            {{ Form::hidden('ycoord', '0', array('id' => 'ycoord')) }}
            <input class="form-control" aria-label="Search" autocomplete="off" id="search" disabled="disabled" type="text" name="search" placeholder="Loading..." @if(isset($search)) value="{{$search}}" @endif maxlength="50" required>
          <input class="search-icon" type="image" src="{{ asset('images/search.svg') }}" style="user-drag: none;user-select: none;-moz-user-select: none;-webkit-user-drag: none;-webkit-user-select: none;-ms-user-select: none;" alt="Submit" />
        </form>
        </div>
      </div>
    </center>

  </div>
</div>
@push('scripts')
  <script src="{{URL::to('js/geolocation-main.js')}}"></script>
@endpush
