@extends('layouts.app')

@section('content')
    <div class="m-auto max-w-6xl mt-8">
        <h1 class="text-4xl font-bold dark:text-gray-200">{{ __('View task') }}: {{ $task->name }}</h1>
        <div class="mt-4 flex flex-col gap-1">
            <p class="dark:text-gray-200">
                <span class="font-bold text-orange-600">{{ __('Name') }}:</span> {{ $task->name }}
            </p>
            <p class="dark:text-gray-200">
                <span class="font-bold text-orange-600">{{ __('Status') }}:</span> {{ $task->status->name }}
            </p>
            <p class="dark:text-gray-200">
                <span class="font-bold text-orange-600">{{ __('Description') }}:</span> {{ $task->description }}
            </p>
        </div>
    </div>
@endsection
