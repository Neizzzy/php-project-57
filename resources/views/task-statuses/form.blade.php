<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" class="" type="text" name="name" :value="old('name', $taskStatus->name ?? '')" autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" />
</div>

