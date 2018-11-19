@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="business-alert alert
                    alert-{{ $message['level'] }}
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
        @if ($message['level'] == 'success')
          <i class="alert-icon">
            <img src="{{URL::to('images/check-green.svg')}}">
          </i>
        @elseif ($message['level'] == 'danger')
          <i class="alert-icon">
            <img src="{{URL::to('images/blocked.svg')}}">
          </i>
        @endif
        <span>@if ($message['important'])</span>
        <button type="button"
            class="close modal-close-custom"
            data-dismiss="alert"
            aria-hidden="true"
    >&times;</button>
    @endif

            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
