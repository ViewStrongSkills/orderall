<div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
	<label for="photo" class="col-md-4 control-label">Фото</label>
	<div class="col-md-6">
		@if($user)
			<img class="photo-small" src="{{ asset('storage/avatars/' . $user->photo) }}">
			<a href="#" class="change-image">Изменить</a>
			<input id="photo" type="file" name="photo" style="display:none">
		@else 
			<input id="photo" type="file" name="photo">
		@endif 
		@if ($errors->has('photo'))
			<span class="help-block">
				<strong>{{ $errors->first('photo') }}</strong>
			</span>
		@endif
	</div>
</div>