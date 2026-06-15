@props(['client' => null])

<div>
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $client?->name)" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $client?->email)" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div class="mt-4">
        <x-input-label for="phone" :value="__('Phone')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $client?->phone)" />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <div class="mt-4">
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="active" @selected(old('status', $client?->status) === 'active')>{{ __('Active') }}</option>
            <option value="inactive" @selected(old('status', $client?->status) === 'inactive')>{{ __('Inactive') }}</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')" />
    </div>
</div>