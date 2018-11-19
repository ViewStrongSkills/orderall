@extends('layouts.master')

@section('content')
		  
	{!! Form::open([
	  'files' => true, 
	  'url' => route('admin.role.store'), 
	  'method' => 'post',
	  'class' => 'form-horizontal form-label-left'
	  ]) !!}

		{{ Form::Text('name') }}

		<div class="accordion modules-list" id="accordion" role="tablist" aria-multiselectable="true">
			@foreach ($modules as $name => $module)
				@php
					$i = $loop->iteration;
				@endphp
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading{{ $i }}">
					  <h4 class="panel-title">
					  	<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $i }}" aria-expanded="true" aria-controls="collapse{{ $i }}">
								{{ $module['title'] }}
			        </a>
					  </h4>
					</div>
					<div id="collapse{{ $i }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $i }}">
						<div class="panel-body">
			      	@foreach ($module['methods'] as $method)
			      		@php
			      			$permission = $name . '.' . $method['key'];
			      		@endphp
				        <label class="permission">
	                <input type="checkbox" class="js-switch" name="permissions[{{$permission}}]"/> {{ $method['title'] }}
	              </label>
			      	@endforeach							
						</div>
					</div>
		  	</div>
			@endforeach
  	</div>

	  {{ Form::submit('Create', ['class' => 'btn btn-success pull-right']) }}

	{!! Form::close() !!}
	

@endsection