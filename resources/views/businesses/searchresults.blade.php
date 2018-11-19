@if ($searchresults->isNotEmpty())
<div class="category-listing">
	<div class="clearfix"></div>
	<div class="row items-wrapper">
		@foreach ($searchresults as $element)
		<div class="col-sm-4 item" id="{{$element->id}}" data="{{route('businesses.show', $element->id)}}" style="cursor: pointer;">
			<div class="map-search-box">
				<div class="widget-img" style="cursor:pointer;">
					<a class="image" href="{{route('businesses.show', $element->id)}}">
						@if($element->image_path)
						<img src="{{Storage::url($element->image_path) }}">
						@else
						<img src="{{asset('images/default.svg')}}" alt="">
						@endif
					</a>
				</div>
				<div class="map-box-body" style="cursor:pointer;">
					<h2>{{$element->name}}</h2>
					<ul class="search-box-description mb-10">
						<li>
							<i class="icon">
								<img src="{{asset('images/star-o.svg')}}" alt="">
							</i>
							<span>{{$element->shortreviews}}</span>
						</li>
						<li>
							<i class="icon">
								<img src="{{ asset('images/clock.svg') }}">
							</i>
							<span>{{$element->currentOpeningHours}}</span>
						</li>
						<li>
							<i class="icon">
								<img src="{{ asset('images/map-marker.svg') }}">
							</i>
							<span>{{$element->addressLine1 . ' ' . $element->addressLine2 . ' ' . $element->locality}}</span>
						</li>
						@if($element->distance)
						<li>
							<i class="icon">
								<img src="{{ asset('images/map-signs.svg') }}">
							</i>
							<span> {{$element->distance}}</span>
						</li>
					@endif
					</ul>
					@include('layouts.tagbox', ['business' => $element])
				</div>
			</div>
		</div>
		@endforeach

		@if ($searchresults->hasMorePages())
	    <link rel="next" href="{{$searchresults->nextPageUrl()}}&ajax=true">
		@else
			@if ($ajax)
				<div class="col-sm-4">
				<div class="search-grid-row" style="padding: 10% 0;background-color:#e0643c;">
					<div class="align-middle" style="text-align: center;padding: 20% 0;"><h1>There's nothing else to show</h1></div>
			</div>
		</div>
			@endif
		@endif
	</div>
</div>
{{-- {{$searchresults->links()}} --}}
@else
	<div class="none-found">
		<p>No businesses found near you which match your search</p>
	</div>
@endif
