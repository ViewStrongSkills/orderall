{{ Form::open(['route' => ['menuextracategories.store', $business->id, $menuitem->id]]) }}
<tr>
  <td>{{ Form::text('name', null, ['class' => 'form-control']) }}</td>
  <td>{{ Form::hidden('required', 0) }}
    {{ Form::checkbox('required', 1, null, ['id'=> 'extra_required']) }}</td>
  <td>{{ Form::submit('Create category', array('class' => 'btn btn-primary')) }}</td>
</tr>
{{ Form::close() }}
