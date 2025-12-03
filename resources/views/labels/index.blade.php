@extends('layouts.app')

@section('content')
    <div class="m-auto max-w-6xl mt-8">
        <h1 class="text-4xl font-bold dark:text-gray-200">{{ __('Labels') }}</h1>
        @can('create', \App\Models\Label::class)
            <x-link-button :href="route('labels.create')" class="mt-4">
                {{ __('Create label') }}
            </x-link-button>
        @endcan
        <div
            class="mt-8 relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white dark:bg-gray-700 shadow-md bg-clip-border rounded-xl">
            <table class="w-full text-left table-auto">
                <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                            {{ __('ID') }}
                        </p>
                    </th>
                    <th class="p-2 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                            {{ __('Name') }}
                        </p>
                    </th>
                    <th class="p-2 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                            {{ __('Description') }}
                        </p>
                    </th>
                    <th class="p-2 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                            {{ __('Creation date') }}
                        </p>
                    </th>
                    @auth
                        <th class="p-2 border-b border-blue-gray-100 bg-blue-gray-50">
                            <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                                {{ __('Actions') }}
                            </p>
                        </th>
                    @endauth
                </tr>
                </thead>
                <tbody>
                @foreach($labels as $label)
                    <tr class="even:bg-blue-gray-50/50">
                        <td class="p-4">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $label->id }}
                            </p>
                        </td>
                        <td class="p-2">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $label->name }}
                            </p>
                        </td>
                        <td class="p-2">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $label->description }}
                            </p>
                        </td>
                        <td class="p-2">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $label->created_at->format('d.m.Y') }}
                            </p>
                        </td>
                        @auth
                            <td class="p-2">
                                <div class="flex gap-3">
                                    @can('delete', $label)
                                        <x-delete-button :route="route('labels.destroy', $label)">{{ __('Delete') }}</x-delete-button>
                                    @endcan
                                    @can('update', $label)
                                        <a href="{{ route('labels.edit', $label) }}" class="block text-sm antialiased font-bold leading-normal text-orange-600 hover:text-orange-800">{{ __('Edit') }}</a>
                                    @endcan
                                </div>
                            </td>
                        @endauth
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-2">
            {{ $labels->links() }}
        </div>
    </div>
@endsection
