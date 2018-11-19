<div class="business-section-main" id="business-menu">
@php
  $user = Auth::user();
@endphp
  @if ($business->menuswithitems->isNotEmpty())
    @foreach ($business->menuswithitems as $menu)
      @if ($menu->open || (Auth::check() && $user->canEditBusiness($business)))
      <hr style="margin-top:5px;margin-bottom:5px;" />
      <h2 class="mb-20" style="text-align:center;">
        @auth
          @if ($user->canEditBusiness($business))
            <a class="menus-edit" href={{route('menus.edit', [$business->id, $menu->id])}}>{{$menu->name}}</a>
            {{$menu->main ? ' (main)' : null}}
          @else
            @if ($menu->main)
              {{$menu->name}}
            @else
              <a class="menus-show" href="{{URL::to('businesses/' . $business->id . '/menus/' . $menu->id)}}">{{$menu->name . ' - ' . $menu->currentOpeningHours}}</a>
            @endif
          @endif
        @endauth
        @guest
          @if ($menu->main)
            {{$menu->name}}
          @else
            <a class="menus-show" href="{{URL::to('businesses/' . $business->id . '/menus/' . $menu->id)}}">{{$menu->name . ' - ' . $menu->currentOpeningHours}}</a>
          @endif
        @endguest
      </h2>
      <hr style="margin-top:5px;margin-bottom:5px;" />
    <div class="mb-20">
      @if(isset($menu->menuitems) && $menu->menuitems->isNotEmpty())
      @foreach ($menu->menuitems->groupBy('category') as $category => $elements)
        <h3 class="mb-20 mt-30">{{$category}}</h3>
        <div class="row">
          @foreach ($elements as $element)
            @include('businesses.menuitem')
          @endforeach
        </div>
      @endforeach

      @else
        <p class="none-found">This menu is empty</p>
      @endif
    </div>
      @endif
    @endforeach
  @endif
</div>
