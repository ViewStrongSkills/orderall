@extends('layouts.master')


@section('content')
	<div class="row">

	{!! Form::model($role, [
	  'files' => true,
	  'url' => route('admin.role.update', $role->id),
	  'method' => 'patch',
	  'class' => 'form-horizontal form-label-left'
	  ]) !!}

		<div class="field col col-xs-12">

			{{ Form::Text('name') }}

			@if ($role->editable)
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
			                <input type="checkbox" name="permissions[{{$permission}}]" {{ $permissions->contains('name', $permission) ? 'checked' : null }} /> {{ $method['title'] }}
			              </label>
					      	@endforeach
								</div>
							</div>
				  	</div>
					@endforeach
		  	</div>
			@endif
		</div>
    <div class="field col-xs-12 col-sm-6">
      {{ Form::submit('Save', ['class' => 'btn btn-success pull-right']) }}
    </div>


	{!! Form::close() !!}
	</div>

@endsection
