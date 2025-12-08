<form action="{{ $attributes->get('href') }}" method="post">
    @csrf
    @method('DELETE')
    <a href="{{ $attributes->get('href') }}"
       onclick="event.preventDefault(); if(confirm('{{ __('Are you sure?') }}')) { this.closest('form').submit(); }"
       class="block text-sm antialiased font-bold leading-normal text-red-600 hover:text-red-800">
        {{ $slot }}
    </a>
</form>
