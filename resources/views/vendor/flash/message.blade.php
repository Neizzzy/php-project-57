@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        @php
            $alertType = match ($message['level']) {
                'success' => 'bg-lime-600 border-lime-700 text-gray-200',
                'danger' => 'bg-red-600 border-red-700 text-gray-200',
                'warning' => 'bg-amber-600 border-amber-700 text-gray-200',
                'info' => 'bg-sky-500 border-sky-600 text-gray-200'
            }
        @endphp
        <div class="alert {{ $alertType }} text-center font-medium py-1" role="alert">
            @if ($message['important'])
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;</button>
            @endif
            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
