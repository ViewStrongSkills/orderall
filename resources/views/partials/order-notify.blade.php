<div id="order-notify" style="display:none" class="span
    @if($transaction->status == 'declined')
      bg-danger
    @else
      bg-success
    @endif
">
    <a href="{{URL::to('/transactions/' . $transaction->id)}}">
      <h3 class="text-dark text-center">
        @if($transaction->status == 'declined')
          Your order from {{$transaction->business->name}} has been declined. {{$transaction->declined_reason}}
        @else
          Your order from {{$transaction->business->name}} has been accepted.
        @endif
        <button type="button" class="close modal-close-custom" id ="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </h3>
    </a>
</div>
