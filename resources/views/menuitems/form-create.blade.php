{{ Form::open(['route' => ['menuitems.store', $business->id], 'files' => true, 'class' => $ajax?'menuitems-ajax-form':null]) }}

<div class="modal-body">
	@include('errors')
	@include('menuitems.form-fields')
</div>
<div class="modal-footer">
  @if ($ajax)
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  	
  @endif
	{{ Form::submit('Create the Menu Item', array('class' => 'btn btn-primary')) }}
</div>

{{ Form::close() }}  
