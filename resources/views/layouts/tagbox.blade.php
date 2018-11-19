@if($business->tags->isNotEmpty())
<div class="tag-box-main">
	<span class="tag-label">Tags:</span>
	<div class="tags-items">
		@foreach($business->tags as  $tag)
			<a class="" href={{route('businesses.tags', $tag->name)}}>
				<label>
					{{$tag->name}} 
				</label>
			</a>
		@endforeach
	</div>
</div>
@endif