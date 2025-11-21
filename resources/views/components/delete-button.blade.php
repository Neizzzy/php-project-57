<form action="{{ $route }}" method="post">
    @csrf
    @method('DELETE')
    <button
        type="submit"
        onclick="return confirm('{{ __('Are you sure?') }}')"
        class="text-red-600 hover:text-red-800 font-bold text-sm"
    >
        {{ $slot }}
    </button>
</form>
