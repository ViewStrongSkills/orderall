@if ($element->extras_categorized->isNotEmpty())

@foreach ($element->extras_categorized as $category)
	@if ($category->menuextras->isNotEmpty())	
		<tr>
			<td colspan="6">
				@if($category->required)
				<h5><strong>{{$category->name}} (Choose one)</strong></h5>
				@else
				<h5><strong>{{$category->name}}</strong></h5>
				@endif
			</td>
		</tr>
		@if($category->required)
			@foreach ($category->menuextras as $extra)
				<tr>
				  <td>{{$extra->name}}</td>
				  <td>$<span class="extraprice">{{$extra->price}}</span></td>
					@if(Auth::check())
				    <td>
				    	<input class="menuextra" id="extra-cat-{{$category->id}}" name="menuextra[]-{{$extra->category->id}}" type="radio" data="{{$extra->id}}" price="{{$extra->price}}">
				    </td>
					@endif
				</tr>
			@endforeach
		@else			
			@foreach ($category->menuextras as $extra)
				<tr>
				  <td>{{$extra->name}}</td>
					<td>$<span class="extraprice">{{$extra->price}}</span></td>
					@if(Auth::check() && $element->orderable)
				    <td>
				    	<input class="menuextra" id="extra-cat-{{$category->id}}" name="menuextra[]-{{$category->id}}" type="radio" data="{{$extra->id}}" price="{{$extra->price}}">
				    </td>
					@endif
				</tr>
			@endforeach
		@endif
	@endif

@endforeach

@endif
