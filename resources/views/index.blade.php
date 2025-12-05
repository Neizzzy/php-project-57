@extends('layouts.app')

@section('content')
    <div class="m-auto max-w-6xl mt-8">
        <div class="min-h-[70vh] flex items-center justify-center flex-col gap-2 relative">
            <div class="flex flex-col items-center">
                <h1 class="font-bold text-6xl dark:text-gray-200 text-center">{{ __('This is a simple task manager on Laravel') }}</h1>
                <a href="https://github.com/Neizzzy" target="_blank" class="bg-orange-500 text-gray-200 px-16 font-bold rounded-b-lg">By Neizzzy</a>
            </div>
            <p class="p-2 font-bold dark:text-gray-200">{{ __('Hello from Hexlet!') }}</p>
            <x-link-button href="https://ru.hexlet.io/" target="_blank" >{{ __('Click me') }}</x-link-button>
        </div>
    </div>
@endsection
