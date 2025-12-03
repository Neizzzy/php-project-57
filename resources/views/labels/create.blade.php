@extends('layouts.app')

@section('content')
    <div class="m-auto max-w-6xl mt-8">
        <h1 class="text-4xl font-bold dark:text-gray-200">{{ __('Create label') }}</h1>
        <div class="mt-8">
            <form action="{{ route('labels.store') }}" method="post">
                @csrf
                @include('labels.form')
                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
