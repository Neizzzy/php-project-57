@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-block px-3 py-1 rounded-md font-medium bg-orange-500 hover:bg-orange-600 transition delay-50 duration-300 text-white dark:text-gray-800 dark:bg-gray-200']) }}>
    {{ $slot }}
</a>
