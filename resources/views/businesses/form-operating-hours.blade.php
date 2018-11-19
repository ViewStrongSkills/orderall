<h3 class="mb-20">Opening Hours</h3>
<div class="row">
	@for($i = 0; $i < 7; $i++)
	@php
		$checked = isset($business->operatinghours[$i]) || old('operatinghours.'.$i.'.opening_time') != null || old('operatinghours.'.$i.'.closing_time') != null;
	@endphp
	<div class="col-sm-6">
		<div class="form-group">
		  	<label>{{$days_long[$i]}}</label>
			<input type="checkbox" class="operatinghours-toggler pull-right" {{$checked ? 'checked' : null}}>
			<div class="operatinghours {{$checked ? null : 'd-none'}}">
				@php
				$oh_ischecked = "";
					if (!$checked) {
						$oh_ischecked = 'disabled="disabled"';
					}
				@endphp
				<div class="row">
					<div class="col-sm-6">
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
