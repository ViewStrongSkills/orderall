{{ Form::open(['route' => ['menus.store', $business->id], 'class' => 'menus-ajax-form']) }}

<div class="modal-body">
	@include('errors')
	@include('menus.form-fields')
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	{{ Form::submit('Create the Menu', array('class' => 'btn btn-primary')) }}
</div>

{{ Form::close() }}
