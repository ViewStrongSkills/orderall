@if ($element->extras_uncategorized)
    <tr>
        <th colspan="3" align="center">
            <h5 class="font-bold">Other Extras</h5>
        </th>
    </tr>
    @foreach($element->extras_uncategorized as $extra)
    <tr class="border-bottom">

      <td width="170">{{$extra->name}}</td>
      <td><span class="col-orange">$</span>{{$extra->price}}</td>
        <td class="new-checkbox">
            <div class="checkbox float-right fl_check ">
                <label>
                    <input price="{{$extra->price}}" class="menuextra float-right" name="{{$extra->name}}" type="checkbox"
                  @if ($cartitem->cartextras->contains('menu_extra_id', $extra->id))
                   checked
                 @endif
                   onchange="addExtraToCart(this, {{$extra->id}}, {{$cartitem->id}})">
                    <i class="helper"></i>
                </label>
            </div>
        </td>
    </tr>
    @endforeach
@endif
