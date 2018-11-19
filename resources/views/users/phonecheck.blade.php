@extends('users.master')
@section('page-title', 'Enter the code we sent you')
@section('user-content')
  <div class="partner-content">
    <h3>Enter your {{config('app.name')}} code</h3>
    <br />
      @include('errors')
      {{ Form::open(['route' => 'updatephone.check']) }}
          <div class="form-group">
                {{ Form::text('code', Input::old('code'), array('class' => 'form-control')) }}
              </div>
        {{ Form::submit('Submit code', ['class' => 'button01 button02']) }}
      {{ Form::close() }}
      @csrf
  </div>
@endsection
