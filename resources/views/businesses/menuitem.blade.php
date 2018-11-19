<div class="col-sm-3 business-menu-item mb-20" id="{{$element->id}}" href="{{URL::to('businesses/' . $element->menu->business->id . '/menuitems/' . $element->id)}}" style="cursor: pointer;">
  <div class="map-search-box">
    <div class="box-img" style="cursor:pointer;">
      <a class="image">
        @if($element->image_path)
        <img class="progressive-image @if(!$element->orderable)image-closed @endif" style="width:100%;" data-fullsize="{{Storage::url('images/menuitems/'.$element->image_path.'.jpg') }}" alt="{{$element->name}}" src="{{Storage::url('images/menuitems/'.$element->image_path.'_low.jpg') }}">
        @else
        <img @if(!$element->orderable) class="image-closed" @endif src="{{asset('images/default.svg')}}" alt="{{$element->name}}">
        @endif
      </a>
    </div>
    <div class="map-box-body" style="cursor:pointer;">
      <h2>{{$element->name}}</h2>
      <ul class="search-box-description inline-li">
        <li>
          <i class="icon"><img src="{{asset('images/star-o.svg')}}" alt=""></i>
          @if(count($element->reviews) > 0)
          <span class="v-align-middle">{{number_format(($element->reviews->sum('rating') / count($element->reviews)), 1) . '/100'}}</span>
          @else
          <span class="v-align-middle">No reviews</span>
        @endif
        </li>
        <li class="pull-right">
          <i class="icon w-auto"><img src="{{ asset('images/dollar.svg') }}"></i>
          @if($element->price > 0)
            @if ($element->discount)
              <span class="price-no"><del>{{$element->price}}</del> {{number_format(($element->price) - ($element->discount), 2)}}</span>
            @else
              <span class="price-no">{{ $element->price }}</span>
            @endif
          @else
            <span>N/A</span>
          @endif
        </li>
      </ul>
      <div class="description inline-li" style="cursor:pointer;">{{$element->description}}</div>
    </div>
  </div>
</div>
