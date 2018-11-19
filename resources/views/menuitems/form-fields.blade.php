<div class="row">
  @include('partials.fields-required')
    <div class="col-sm-6">
        <div class="form-group required">
          {{ Form::label('menu_id', 'Menu') }}
          {{ Form::select('menu_id', $business->menus->pluck('name', 'id'), null, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
          {{ Form::label('name', 'Menu Item Name') }}
          {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
          {{ Form::label('price', 'Price') }}
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupPrepend">$</span>
          </div>
          {{ Form::text('price', Input::old('price'), array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
          {{ Form::label('discount', 'Discount') }}
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupPrepend">$</span>
          </div>
          {{ Form::text('discount', Input::old('discount'), array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group required">
          {{ Form::label('category', 'Category') }}
          {{ Form::text('category', Input::old('category'), array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group required">
          {{ Form::label('description', 'Description') }}
          {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
          @include('partials.form-file', [
            'name'=>'image',
            'label'=>'Image (Maximum size 512KB, PNG, JPEG or BMP, will be cropped to 7:4)',
            'file'=>isset($menuitem->image_path) ? 'images/menuitems/' . $menuitem->image_path . '.png' : null,
          ])
        </div>
    </div>
</div>
