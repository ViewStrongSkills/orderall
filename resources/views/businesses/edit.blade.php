@extends('layouts.master')
@push('styles')
	<link href="{{URL::to('css/select2.min.css')}}" rel="stylesheet" />
@endpush
@push('scripts')
	<script src="{{URL::to('js/select2.min.js')}}"></script>
@endpush

@section('page-title', 'Edit your business')
@section('content')
<div class="clearfix"></div>
<div class="container">
    <h1 class="mt-40">Edit
        <a class="edit-link" href="{{URL::to('/businesses/' . $business->id)}}">{{$business->name}}</a>
        <div class="pull-right">
            @include('partials.button-delete', ['model'=> $business, 'route'=> ['businesses.destroy', $business->id], 'text' => 'Delete your Business'])
        </div>
    </h1>

    @include('errors')

    {{ Form::model($business, ['route' => ['businesses.update', $business->id], 'method' => 'PUT', 'files'=>'true','class'=>'mb-40']) }}

    @include('businesses.form-fields')

    {{ Form::submit('Save your changes', ['class' => 'btn btn-primary', 'style' => 'width:100%;']) }}
    {{ Form::close() }}
</div>
@endsection
