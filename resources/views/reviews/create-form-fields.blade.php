<script>
  $( "#rating-input" ).keypress(function( event ) {
    var re = new RegExp("/d");
    if ( (!(isFinite(event.key))) || ($('#rating-input').val().length > 2) ) {
       event.preventDefault();
    }
  });
</script>
{{ Form::open(['route' => ['reviews.store', $business->id, $menuitem->id]]) }}
    <div class="form-group required">
          {{ Form::label('rating', 'Rating (out of 100)') }}
          {{ Form::number('rating', Input::old('rating'), array('class' => 'form-control', 'id' => 'rating-input', 'min' => '0', 'max' => '100', 'placeholder' => 'Eg. 63')) }}
        </div>
        <div class="form-group required">
          {{ Form::label('content', 'Review') }}
          {{ Form::textarea('content', Input::old('content'), array('class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'I really liked it! However, the toppings were a bit thin.')) }}
        </div>
        <div class="form-group">
          {{ Form::hidden('menu_item_id', $menuitem->id) }}
        </div>
  {{ Form::submit('Add review', ['class' => 'button01']) }}
{{ Form::close() }}
