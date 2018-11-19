<p>
  <label for="fielsd-{{ $name }}">{{ $label }}</label>
	{{ Form::select($name, $options, $selected, $attributes) }}
  @if ($errors->has($name))
    <strong>{{ $errors->first($name) }}</strong>
  @endif
	
</p>