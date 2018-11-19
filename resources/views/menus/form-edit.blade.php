<div class="modal-body">
	@if(!$menu->main)
		@include('partials.button-delete', ['model'=> $menu, 'route'=> ['menus.destroy', $business->id, $menu->id], 'text' => 'Delete menu'])
	@endif
{{ Form::model($menu, ['route' => ['menus.update', $business->id, $menu->id],
'method' => 'PUT', 'class' => 'menus-ajax-form']) }}
		@include('errors')
		@include('menus.form-fields')
		<div class="modal-footer">
			{{ Form::submit('Edit ' . $menu->name, ['class' => 'btn btn-primary']) }}
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
	</div>
	{{ Form::close() }}
