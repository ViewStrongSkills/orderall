{{ Form::model($menuextra, ['route' => ['menuextras.update', $business->id, $menuitem->id, $menuextra->id], 'method' => 'PUT', 'class' => $ajax?'menuextras-ajax-form':null, 'data-menuitem-id' => $menuitem->id]) }}

	<div class="modal-body">
		@include('errors')
		@include('menuextras.form-fields')
	</div>
	<div class="modal-footer">
	  @if ($ajax)
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>  	
	  @endif
		{{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
	</div>
{{ Form::close() }}