<tr id={{$extra->id}}>
  <td>{{$extra->name}}</td>
  <td>${{$extra->price}}</td>
  @if($extra->category)
  <td>{{$extra->category->name}}@if($extra->category->required) (Required) @endif</td>
  @else
  <td>N/A</td>
  @endif
  <td>
    <a class="btn btn-large btn-primary openbutton menuextras-edit" href="{{route('menuextras.edit', [$business->id, $menuitem->id, $extra->id])}}">Edit</a>
  </td>
  <td>
    @include('partials.button-delete', ['model'=> $extra, 'route'=> ['menuextras.destroy', $business->id, $menuitem->id, $extra->id], 'text' => 'Delete'])
  </td>
</tr>
