@extends('layouts.master')
@push('styles')
	<link href="{{URL::to('css/select2.min.css')}}" rel="stylesheet" />
@endpush
@push('scripts')
	<script src="{{URL::to('js/select2.min.js')}}"></script>
@endpush

@section('page-title', 'Add a new business')

@section('content')
<div class="clearfix"></div>
<div class="container">
    <h1 class="mt-40 mb-20">Add a new Business</h1>
	<p class="mb-20">Follow the <a href="{{URL::to('/business-guide')}}">guide for businesses</a> setting up their Orderall page</p>
    @include('errors')

    {{ Form::open(['route' => 'businesses.store', 'files'=>'true', 'class'=>'mb-40']) }}
    @include('businesses.form-fields')
		<div class="form-group required">
			<input type="checkbox" name="business-tos">I agree to the <a target="_blank" href="{{URL::to('business-tos')}}">Terms of Service for Businesses</a>
		</div>
    {{ Form::submit('Create the Business', ['class' => 'btn btn-primary', 'style' => 'width:100%;']) }}

    {{ Form::close() }}
</div>
@endsection
