@php

    $selected_category = [];
    if (old('category')){
      $selected_category = [old('category')];
    }
    else {
      if(isset($menuextra)){
        $selected_category = isset($menuextra->category) ? [$menuextra->category->name] : [];
      }
    }

    $categories = $menuitem->menuextra_categories->pluck('name', 'name');

@endphp

@include('partials.fields-required')
<div class="form-group required">
  {{ Form::label('name', 'Menu Extra Name') }}
  {{ Form::text('name', null, ['class' => 'form-control']) }}
</div>
<div class="form-group required">
  {{ Form::label('price', 'Price') }}
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroupPrepend">$</span>
  </div>
  {{ Form::text('price', null, ['class' => 'form-control'])}}
</div>
<div class="form-group required">
  {{ Form::label('category', 'Category') }}
  {{ Form::select('category', $categories, $selected_category, ['class' => 'form-control select-menuextra-category', 'placeholder' => 'Select category', 'multiple'])}}
</div>
