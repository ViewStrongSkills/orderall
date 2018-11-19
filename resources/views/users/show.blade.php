@extends('users.master')
@section('page-title', 'Your Account')
@section('user-content')
                    <div class="profile-detail">
                        <div class="general-info">

                            <h2>User Information</h2>


                            <div class="account-info">
                              @if ($user->roles()->first()->name == 'UnauthUser')
                                <p>Your email address is not verified</p>
                                <p>Check your email inbox to verify</p>
                                <p>If you are a business, please wait while your request is processed.</p>
                              @else
                                <p>{{ucfirst($user->roles()->first()->display_name)}}</p>
                              @endif

                            </div>
                        </div>
                        <div class="account-view">
                            <div class="form-group">
                                <label>Name</label>
                                <span>{{$user->first_name . ' ' . $user->last_name}}</span>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <span>{{$user->email}}</span>
                            </div>
                            @permission('updatephone.check')
                              <div class="form-group">
                                  <label>Phone Number</label>
                                  <span>
                                  @if($user->phone)
                                  {{$user->phone}}
                                  @endif

                                  @if(!$user->phone)
                                  <a class="btn btn-xs btn-primary openbutton" href="{{URL::to('/setphone')}}">Add a phone number to your account</a>
                                  @else
                                  <a class="btn btn-xs btn-primary openbutton" href="{{URL::to('/setphone')}}">Update</a>
                                  @endif
                                  </span>
                              </div>
                            @endpermission
                        </div>

                        <div class="general-info mt100">

                            <h2>Account Preferences</h2>



                        </div>
                        <div class="notification-tabs mt20 ">
                            <span> <img src="{{URL::to('images/envelope.svg')}}" alt=""> &nbsp
                            @if($user->subscribed)
                              <a class="btn btn-xs btn-primary openbutton" href="{{URL::to('/unsubscribe/' . $user->unsub_token)}}">Unsubscribe from all email notifications</a>
                            @else
                              <a class="btn btn-xs btn-primary openbutton" href="{{URL::to('/subscribe')}}">Subscribe to email notifications</a>
                            @endif
                             </span>
                        </div>
                        {{--
                        <div class="notification-tabs mt20 ">
                            <span> <img src="{{URL::to('images/bell.svg')}}" alt=""> &nbsp
                            @if($user->subscribed)
                              <a class="btn btn-xs btn-primary openbutton" href="{{URL::to('/subscription/unsubscribe')}}">Unsubscribe from all email notifications</a>
                            @else
                              <a class="btn btn-xs btn-primary openbutton" href="{{URL::to('/subscription/subscribe')}}">Subscribe to email notifications</a>
                            @endif
                             </span>
                        </div>--}}

                        @if (Auth::user()->deleteable)
                        <div class="notification-tabs mt20">
                            {{ Form::model($user, [
                                'route' => ['account.destroy', $user->id],
                                'method' => 'DELETE',
                            ]) }}
                            <span>
                              <img src="{{URL::to('images/trash-o.svg')}}" class="mr5">
                              {{ Form::submit('Delete account', [
                              'class' => 'btn btn-xs btn-primary openbutton',
                              'onclick' => 'return confirm("Are you sure you want to delete your account?")'
                            ])}}</span>
                            {{ Form::close() }}
                        </div>
                      @endif
                    </div>
@endsection
