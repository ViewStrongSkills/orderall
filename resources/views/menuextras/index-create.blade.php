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
<tr>
  {{ Form::open(['route' => ['menuextras.store', $business->id, $menuitem->id]]) }}
  <td>{{ Form::text('name', null, ['class' => 'form-control']) }}</td>
  <td>{{ Form::text('price', null, ['class' => 'form-control'])}}</td>
  <td>{{ Form::select('category', $categories, $selected_category, ['class' => 'form-control select-menuextra-category', 'placeholder' => 'Select category', 'multiple'])}}</td>
  <td>{{ Form::submit('Create', ['class' => 'btn btn-primary']) }}</td>
  {{ Form::close() }}
</tr>
