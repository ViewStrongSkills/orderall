@extends('layouts.master')

@section('page-title', 'Search: ' . $search)
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
      <div class="col-sm-2">
        <h2>Search</h2>
      </div>
      <script type="text/javascript">
        function setRadius(rad)
        {
          $('#search-radius').val(rad);
          $('#searchform').submit();
        }
      </script>
      <div class="col-sm-2 pull-right">
        {{ Form::select('search-radius', ['10' => '10km', '20' => '20km', '30' => '30km', '40' => '40km', '50' => '50km'], (isset($radius) ? $radius : 10), ['class' => 'form-control', 'style' => 'cursor:pointer;height:65%;border:solid 1px #F18446;', 'onChange' => 'setRadius((this.options[this.selectedIndex]).value);']) }}
      </div>
    </div>
    <div class="all-search-listing">
    <div class="container">
      <div class="items-list infinite-scroll">
        @include('businesses.searchresults')
      </div>
    </div>
    </div><!--all-search-listing-->
  </div>
</div>
@endsection
