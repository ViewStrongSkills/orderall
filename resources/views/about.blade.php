@extends('layouts.master')

@section('page-title', 'About Orderall')
@section('content')
<div class="middle-contact">
<div class="container">
<div class="page-head-content">
<h2>About Orderall</h2>
</div>
<div class="static-content static-content-help">
<div class="col-md-6">
  <img class="" src="{{URL::to('/images/joe_gibbs.png')}}" width="75%" alt="">
</div>
<div class="col-md-6">
  <p>Orderall was created by a team led by Joe Gibbs, a student at Swinburne
University of Technology in Melbourne, Victoria. Work on Orderall began in May 2018 and the
first version was released in October.</p>
</div>
<div class="mt50"></div>
</div>
</div>
</div>
@endsection
