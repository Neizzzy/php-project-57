<div class="flex flex-col gap-4">
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="w-80" type="text" name="name" :value="old('name', $label->name ?? '')" autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea name="description" id="description" rows="5" cols="33" class="w-80 h-32 resize-none border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm">
            {{ old('description', $label->description ?? '') }}
        </textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
