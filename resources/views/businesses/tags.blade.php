@extends('layouts.master')

@section('page-title', 'Restaurants tagged with "' . $tag->name . '"')
@push('scripts')
  {{HTML::script('js/infinite-scroll.js')}}
  <script type="text/javascript">
    $(document).ready(function(){
      $('body').on('click', '.item', function(e){
        e.preventDefault();
        var clickable = '<a id="tabLink" href=' + $(this).attr("data") + ' target="_blank" style="display: none;"></a>';
        $('body').append(clickable);
        document.getElementById("tabLink").click();
        $('#tabLink').remove();
        })
    });
  </script>
@endpush
@section('content')
<div class="middle-contact">
	<div class="container">
		<div class="page-head-content">
			<h1 class="mt-0 box-border-title">Businesses tagged with "{{$tag->name}}"</h1>
		</div>
		<div class="all-search-listing">
			@include('businesses.searchresults')
		</div><!--all-search-listing-->
	</div>
</div>
@endsection
