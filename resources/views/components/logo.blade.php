@props(['size' => 'md'])

@php
    $sizes = [
        'sm' => ['logo' => 'w-10 h-10', 'text' => 'text-xs'],
        'md' => ['logo' => 'w-12 h-12', 'text' => 'text-sm'],
        'lg' => ['logo' => 'w-20 h-20', 'text' => 'text-base'],
    ];

    $currentSize = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-1']) }}>
    <x-application-logo class="{{ $currentSize['logo'] }}" />
    <div class="font-bold light:text-black dark:text-gray-200 {{ $currentSize['text'] }} leading-tight break-all">
        {!! __('TASK<br>MANAGER') !!}
    </div>
</div>
