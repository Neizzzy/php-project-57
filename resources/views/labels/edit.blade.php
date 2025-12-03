@extends('layouts.app')

@section('content')
    <div class="m-auto max-w-6xl mt-8">
        <h1 class="text-4xl font-bold dark:text-gray-200">{{ __('Edit label') }}</h1>
        <div class="mt-8">
            <form action="{{ route('labels.update', $label) }}" method="post">
                @csrf
                @method('PATCH')
                @include('labels.form')
                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
