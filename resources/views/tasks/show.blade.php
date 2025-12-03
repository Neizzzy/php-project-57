@extends('layouts.app')

@section('content')
    <div class="m-auto max-w-6xl mt-8">
        <div class="flex items-center gap-4">
            <h1 class="text-4xl font-bold dark:text-gray-200">{{ __('View task') }}: {{ $task->name }}</h1>
            <a href="{{ route('tasks.edit', $task) }}" class="text-2xl hover:scale-110">✏️</a>
        </div>
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
            @if($task->labels()->exists())
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-orange-600">{{ __('Labels') }}:</p>
                    <div class="flex gap-2 flex-wrap">
                        @foreach($task->labels as $label)
                            <div class="px-3 py-1 bg-orange-600 text-white rounded-xl">
                                {{ $label->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
