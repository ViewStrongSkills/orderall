<script type="text/javascript">
  function clearCategory(category, cartitem)
  {
    $('input:radio').each(function(index, element){
      if ($(element).attr('category') == category) {
        element.checked = false;
        addExtraToCart(element, $(element).attr("data"), cartitem);
      }
    });
  }
</script>
@foreach ($element->extras_categorized as $category)
  @if (count($category->menuextras) > 0)
    <tr>
      <th colspan="3" align="center">
        <h5 class="font-bold">{{$category->name}}
          @if($category->required)
            (Choose one)
          @endif

          @if (!$category->required)
            <span class="pull-right close-extra" onclick="clearCategory($(this).attr('category'), {{$cartitem->id}})" category="{{$category->id}}" style="cursor: pointer;">×</span>
          @endif
        </h5>
      </th>
    </tr>
    @foreach ($category->menuextras as $extra)
      <tr class="border-bottom">
        <td width="170">{{$extra->name}}</td>
        <td><span class="col-orange">$</span> <span class="extraprice">{{$extra->price}}</span></td>
        <td style="text-align: right;">
          <label class="rad">
            <input class="menuextra" category="{{$category->id}}" name="menuextra[]-{{$extra->category->id . '-' . $cartitem->id}}"
                   @if ($cartitem->cartextras->contains('menu_extra_id', $extra->id))
                   checked
                   @endif
                   onchange="addExtraToCart(this, {{$extra->id}}, {{$cartitem->id}})"
                   type="radio" data="{{$extra->id}}" price="{{$extra->price}}">
            <i></i>
          </label>
        </td>

      </tr>
    @endforeach
  @endif
@endforeach
