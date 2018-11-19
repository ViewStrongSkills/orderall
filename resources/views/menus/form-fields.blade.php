@include('partials.fields-required')
<div class="form-group required">
  {{ Form::label('name', 'Menu Name') }}
  {{ Form::text('name', null, ['class' => 'form-control']) }}
</div>

@if ($business->menus->isNotEmpty() || (isset($menu) && !$menu->main))
	@include('menus.form-operating-hours')
@endif
