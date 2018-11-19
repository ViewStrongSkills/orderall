@if (isset($menu) && $menu->main)
{{-- Do not output schedule for main menu --}}
@else

	@php
	  $days_long = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
	  // dd($menu->operatinghours);
	@endphp
	<fieldset class="custom-filedset">
		<legend><h3 class="font-bold">Operating Hours</h3></legend>
		<div class="row">
			@for($i = 0; $i < 7; $i++)
			@php
				$checked = isset($menu->operatinghours[$i]) || old('operatinghours.'.$i.'.opening_time') != null || old('operatinghours.'.$i.'.closing_time') != null;
			@endphp
			@php
			$oh_ischecked = "";
				if (!$checked) {
					$oh_ischecked = 'disabled="disabled"';
				}
			@endphp
			<div class="col-sm-6">
				<div class="form-group text-left">
				  	<label>{{$days_long[$i]}}</label>
					<input type="checkbox" class="operatinghours-toggler pull-right" {{$checked ? 'checked' : null}}>
					<div class="operatinghours {{$checked ? null : 'd-none'}}">
						<div class="row">
							<div class="col-sm-6 pad-r-0">
					    		{{Form::text('operatinghours['.$i.'][opening_time]', null, ['class' => 'form-control w-25', 'maxlength' => '5', 'placeholder' => '09:00', $oh_ischecked]) }}
					    	</div>
					    	<div class="col-sm-6">
						    	{{Form::text('operatinghours['.$i.'][closing_time]', null, ['class' => 'form-control w-25', 'maxlength' => '5', 'placeholder' => '21:30', $oh_ischecked]) }}
						    </div>
					    </div>
				    </div>
				</div>
			</div>
			@endfor
		</div>
	</fieldset>
@endif
