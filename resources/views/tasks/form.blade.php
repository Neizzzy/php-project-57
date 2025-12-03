<div class="flex flex-col gap-4">
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="w-80" type="text" name="name" :value="old('name', $task->name ?? '')" autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea name="description" id="description" rows="5" cols="33" class="w-80 h-32 resize-none border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
            {{ old('description', $task->description ?? '') }}
        </textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>

    <div>
        <x-input-label for="status_id" :value="__('Status')" />
        <select name="status_id" id="status_id" class="w-80 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
            <option value="">{{ __('Select status') }}</option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}" @selected(old('status_id', $task->status_id ?? '') == $status->id)>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status_id')" />
    </div>

    <div>
        <x-input-label for="assigned_to_id" :value="__('Executor')" />
        <select name="assigned_to_id" id="assigned_to_id" class="w-80 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
            <option value="">{{ __('Select executor') }}</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('assigned_to_id', $task->assigned_to_id ?? '') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('assigned_to_id')" />
    </div>

    <div>
        <x-input-label for="labels" :value="__('Labels')" />
        <select name="labels[]" id="labels" multiple class="w-80 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
            @foreach($labels as $label)
                <option value="{{ $label->id }}" @selected(isset($task) ? $task->labels->contains($label->id) : in_array($label->id, old('labels', [])))>
                    {{ $label->name }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('labels')" />
    </div>
</div>
