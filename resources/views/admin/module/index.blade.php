@extends('layouts.master')

@section('breadcrumb')
  <li class="active">Modules</li>	
@endsection

@section('content')

	<div class="page-title">
	  <div class="title_left">
	    <h3>Modules</h3>
	  </div>
	</div>

  <div class="clearfix"></div>

	{!! Form::open([
	  'files' => true, 
	  'url' => route('admin.module.store'), 
	  'method' => 'post',
	  'class' => 'form-horizontal form-label-left'
	  ]) !!}
 
		<table class="table">
			<thead>
				<tr>
					<th>Route</th>
					<th>Title</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($modules as $key => $value)
					<tr>
						<td>
							<h5>{{ $key }}</h5>
							<input type="hidden" name="modules[{{ $loop->iteration }}][route]" value="{{ $key }}">
						</td>
						<td>
							<input type="text" name="modules[{{ $loop->iteration }}][title]" value="{{ $value['title'] }}" class="form-control">
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>


	  <div class="col-xs-12">
	    <div class="form-group">
			  <hr class="ln_solid">
	      {{ Form::submit('Save', ['class' => 'btn btn-success pull-right']) }}
	    </div>
	  </div>

	{!! Form::close() !!}

@endsection