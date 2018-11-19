{{Form::model($model, [
	'route' => $route,
  'method' => 'DELETE',
  'class' => 'form-inline',
  'onSubmit' => 'return confirm("Delete this entry?")',
])}}
  {{Form::submit($text, ['class' => 'btn btn-danger w-100'])}}
{{Form::close()}}
