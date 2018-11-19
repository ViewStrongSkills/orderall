	{{ Form::text($name, null, [
		'name' => $name,
		'class' => 'form-control',
		'id' => 'field-'.$name,
		'placeholder' => $label
		]) }}
  @if ($errors->has($name))
    <strong>{{ $errors->first($name) }}</strong>
  @endif
