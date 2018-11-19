<div class="modal-body">
  @if(Auth::check())
    @if (Auth::user()->canEditBusiness($business))
    <div class="row mb-20">
        <div class="col-sm-4">
          <a class="btn btn-large w-100 btn-outline-primary openbutton menuitems-edit" href="{{route('menuitems.edit', [$business->id, $element->id])}}">Edit</a>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-large w-100 btn-primary openbutton menuextras-index" href="{{route('menuextras.index', [$business->id, $element->id])}}">Extras</a>
        </div>
        <div class="col-sm-4">
          @include('partials.button-delete', ['route'=> ['menuitems.destroy', $business->id, $element->id], 'model' => $business,'text' => 'Delete'])
        </div>
    </div>
    @endif
  @endif

  <a class="image">
    @if($element->image_path)
      <img width="100%" src="{{Storage::url('images/menuitems/'.$element->image_path.'.jpg') }}">
    @else
      <img width="100%" src="{{asset('images/default.svg')}}" alt="">
    @endif
  </a>
  <div class="map-box-body">
    <h2>{{$element->name}}</h2>
    <div class="search-box-description">
    <ul>
      <li>
        <i class="icon">
            <img src="{{asset('images/star-o.svg')}}" alt="">
        </i>
        @if(count($element->reviews) > 0)
          <span href="{{URL::to('/businesses/' . $business->id . '/menuitems/' . $element->id . '/reviews')}}" class="reviews-show"><a href="{{URL::to('/businesses/' . $business->id . '/menuitems/' . $element->id . '/reviews')}}">{{number_format(($element->reviews->sum('rating') / count($element->reviews)), 1) . '/100'}}</a></span>
        @else
          <span>No reviews yet</span>
        @endif
        @if (Auth::check() && Auth::user()->canReviewItem($element))
          <span> - <a class="reviews-create" href="{{route('reviews.create', [$business->id, $element->id])}}">Add your review</a></span>
        @endif
      </li>
      <li>
        <i class="icon">
            <img src="{{ asset('images/dollar.svg') }}">
        </i>
        @if($element->price > 0)
          @if ($element->discount)
            <span id="itemprice" class="price-no" price="{{($element->price) - ($element->discount)}}"><del>{{$element->price}}</del> {{number_format(($element->price) - ($element->discount), 2)}}</span>
          @else
            <span id="itemprice" class="price-no" price="{{$element->price}}">{{ $element->price }}</span>
          @endif
        @else
          <span id="itemprice" price="0">N/A</span>
        @endif
      </li>
    </ul>
    <div class="description">{{$element->description}}</div>
    </div>
  </div>
  {{ Form::open(['route' => ['cartitems.add'], 'class' => 'business-menu-item-form', 'method' => 'POST']) }}
  {{ Form::hidden('menuitem', $element->id)}}
  @if ($element->extras_categorized->isNotEmpty() || $element->extras_uncategorized->isNotEmpty())
  <table class="table mt-40">
    @include('businesses.menuextras-categorized')
    @if ($element->extras_uncategorized->isNotEmpty())
      <tr>
        <td colspan="6">
          <h5>
            <strong>
              Other extras
            </strong>
          </h5>
        </td>
      </tr>
      @include('businesses.menuextras-uncategorized')
    @endif
  </table>
  @endif
  @if(Auth::check() && $element->menu->open)
  <label for="comments">Comments</label>
  <br />
  <input class="form-control" type="text" name="comments" maxlength="127" value="">
  @endif
  @if(Auth::check() && $business->open && $element->orderable)
  @if($element->price > 0)
    @if ($element->discount)
      <p>Total price: $<span id="menuitem-totalprice">{{number_format(($element->price) - ($element->discount), 2)}}</span></p>
    @else
      <p>Total price: $<span id="menuitem-totalprice">{{$element->price}}</span></p>
    @endif
  @else
    <p>Total price: $<span id="menuitem-totalprice">0.00</span></p>
  @endif
  {{ Form::submit('Add to cart', ['class' => 'btn btn-success', 'style' => 'width:100%;']) }}
  @endif
  {{Form::close()}}
</div>
