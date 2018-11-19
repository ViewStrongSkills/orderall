<div class="modal fade" id="modal-menuitem" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">{{$title}}</h5>
        <button type="button" class="close modal-close-custom" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="ajax-wrapper">
        @include('menuitems.form-'.$action)
      </div>
    </div>
  </div>
</div>
