@extends('layouts.app')

@section('content')
    <div class="m-auto max-w-6xl mt-8">
        <h1 class="text-4xl font-bold dark:text-gray-200">{{ __('Tasks') }}</h1>
        @can('create', \App\Models\Task::class)
            <x-link-button :href="route('tasks.create')" class="mt-4">
                {{ __('Create task') }}
            </x-link-button>
        @endcan
        <div class="mt-8">
            <h2 class="text-2xl font-bold dark:text-gray-200">{{ __('Filter') }}</h2>
            <div class="mt-2">
                <form action="{{ route('tasks.index') }}">
                    <div class="flex flex-col gap-2 items-start">
                        <div class="flex gap-1 items-center flex-wrap">
                            <select name="filter[status_id]" id="status_id" class="w-80 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
                                <option value="">{{ __('Status') }}</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @selected($status->id == request('filter.status_id'))>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="filter[created_by_id]" id="created_by_id" class="w-80 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
                                <option value="">{{ __('Author') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($user->id == request('filter.created_by_id'))>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="filter[assigned_to_id]" id="assigned_to_id" class="w-80 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
                                <option value="">{{ __('Executor') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($user->id == request('filter.assigned_to_id'))>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-4 items-center">
                            <x-primary-button>
                                {{ __('Apply') }}
                            </x-primary-button>
                            @if(!empty(request('filter')))
                                <a href="{{ route('tasks.index') }}" class="text-red-600 hover:text-red-800 font-bold text-sm">{{ __('Reset filter') }}</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-4 relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white dark:bg-gray-700 shadow-md bg-clip-border rounded-xl">
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
                            {{ __('Status') }}
                        </p>
                    </th>
                    <th class="p-2 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                            {{ __('Name') }}
                        </p>
                    </th>
                    <th class="p-2 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                            {{ __('Author') }}
                        </p>
                    </th>
                    <th class="p-2 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p class="block text-start text-sm antialiased font-normal leading-none text-blue-gray-900 dark:text-gray-200 opacity-70">
                            {{ __('Executor') }}
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
                @foreach($tasks as $task)
                    <tr class="even:bg-blue-gray-50/50">
                        <td class="p-4">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $task->id }}
                            </p>
                        </td>
                        <td class="p-2">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $task->status->name }}
                            </p>
                        </td>
                        <td class="p-2">
                            <a href="{{ route('tasks.show', $task) }}" class="block text-sm antialiased font-normal leading-normal text-orange-400">
                                {{ $task->name }}
                            </a>
                        </td>
                        <td class="p-2">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $task->creator->name }}
                            </p>
                        </td>
                        <td class="p-2">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $task->executor->name ?? '' }}
                            </p>
                        </td>
                        <td class="p-2">
                            <p class="block text-sm antialiased font-normal leading-normal text-blue-gray-900 dark:text-gray-200">
                                {{ $task->created_at->format('d.m.Y') }}
                            </p>
                        </td>
                        @auth
                            <td class="p-2">
                                <div class="flex gap-3">
                                    @can('delete', $task)
                                        <x-delete-button :href="route('tasks.destroy', $task)">{{ __('Delete') }}</x-delete-button>
                                    @endcan
                                    @can('update', $task)
                                        <a href="{{ route('tasks.edit', $task) }}" class="block text-sm antialiased font-bold leading-normal text-orange-600 hover:text-orange-800">{{ __('Edit') }}</a>
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
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
