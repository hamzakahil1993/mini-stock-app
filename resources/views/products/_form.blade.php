@props(['product' => null])

<div>
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product?->name)" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div class="mt-4">
        <x-input-label for="image" :value="__('Image')" />
        @if ($product?->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mt-2 h-24 w-24 rounded-lg object-cover ring-1 ring-gray-200">
        @endif
        <input id="image" name="image" type="file" accept="image/*"
            class="mt-2 block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
        <x-input-error class="mt-2" :messages="$errors->get('image')" />
    </div>

    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $product?->description) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    <div class="mt-4">
        <x-input-label for="price" :value="__('Price')" />
        <x-text-input id="price" name="price" type="number" min="0" class="mt-1 block w-full" :value="old('price', $product?->price)" required />
        <x-input-error class="mt-2" :messages="$errors->get('price')" />
    </div>

    <div class="mt-4">
        <x-input-label for="currency" :value="__('Currency')" />
        <select id="currency" name="currency" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            @foreach (['EUR', 'CHF', 'USD', 'DZD'] as $currency)
            <option value="{{ $currency }}" @selected(old('currency', $product?->currency ?? 'EUR') === $currency)>{{ $currency }}</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('currency')" />
    </div>

    <div class="mt-4">
        <x-input-label for="quantity" :value="__('Quantity')" />
        <x-text-input id="quantity" name="quantity" type="number" min="0" class="mt-1 block w-full" :value="old('quantity', $product?->quantity)" required />
        <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
    </div>
</div>