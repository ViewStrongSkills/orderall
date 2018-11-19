<tr id={{$category->id}}>
  <td>{{$category->name}}</td>
  <td><input type="checkbox" disabled name=""
  @if($category->required)
    checked="checked"
  @endif
  ></td>
  <td>
    <a class="btn btn-outline-primary openbutton menuextracategories-edit" href="{{route('menuextracategories.edit', [$business->id, $menuitem->id, $category->id])}}">Edit category</a>
    @include('partials.button-delete', ['model'=> $category, 'route'=> ['menuextracategories.destroy', $business->id, $menuitem->id, $category->id], 'text' => 'Delete category'])
  </td>
</tr>
