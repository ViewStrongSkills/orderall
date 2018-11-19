@if ($element->extras_uncategorized->isNotEmpty())
  @foreach($element->extras_uncategorized as $extra)
  <tr>
    <td>{{$extra->name}}</td>
    <td>$<span class="extraprice">{{$extra->price}}</span></td>
    @if(Auth::check() && $element->orderable)
      <td><input class="menuextra" name="menuextra[]" type="checkbox" data="{{$extra->id}}" price="{{$extra->price}}"></td>
    @endif
  </tr>
  @endforeach
@endif
