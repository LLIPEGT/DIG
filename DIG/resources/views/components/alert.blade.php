@props(['type' => 'info', 'message' => null, 'dismissible' => true])

@php
    $messages = $message ?? session()->get($type, []);
    $iconClass = match($type) {
        'success' => 'bi-check-circle-fill',
        'danger' => 'bi-exclamation-triangle-fill',
        'warning' => 'bi-exclamation-circle-fill',
        'info' => 'bi-info-circle-fill',
        default => 'bi-info-circle-fill'
    };
    $alertClass = "alert alert-{$type} alert-dismissible fade show rounded-3 shadow-sm";
@endphp

@if(!empty($messages))
    <div class="{{ $alertClass }} {{ $dismissible ? 'border-0' : '' }}">

        <i class="{{ $iconClass }} me-2 fs-5 align-middle"></i>

        @if(is_array($messages))
            @if(count($messages) === 1)
                <strong class="me-2">{{ $messages[0] }}</strong>
            @else
                <ul class="mb-0 ms-3">
                    @foreach($messages as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                </ul>
            @endif
        @else
            <strong>{{ $messages }}</strong>
        @endif

        @if($dismissible)
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @endif
    </div>
@endif
