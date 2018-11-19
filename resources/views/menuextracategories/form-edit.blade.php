{{ Form::model($menuextracategory, ['route' => ['menuextracategories.update',
  $business->id, $menuitem->id, $menuextracategory->id], 'method' => 'PUT',
  'class' => $ajax?'menuextracategories-ajax-form':null, 'data-menuitem-id' => $menuitem->id]) }}
  <div class="modal-body">
    @include('errors')
    @include('partials.fields-required')
    <div class="form-group required">
      {{ Form::label('name', 'Category Name') }}
      {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
    <div class="form-group">
      {{ Form::label('required', 'Required?') }}
      {{ Form::hidden('required', 0) }}
      {{ Form::checkbox('required', 1, null, ['id'=> 'extra_required']) }}
    </div>
  </div>
  <div class="modal-footer">
    @if ($ajax)
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    @endif
    {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
  </div>
{{ Form::close() }}
