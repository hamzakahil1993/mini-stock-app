<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Add Product') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
            <div class="mb-4 flex items-center gap-2 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg shadow-sm">
                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('status') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm ring-1 ring-gray-200 sm:rounded-xl">
                @if ($products->isEmpty())
                <div class="p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">{{ __('No products yet.') }}</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Description') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Price') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Quantity') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-lg object-cover ring-1 ring-gray-200">
                                        @else
                                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </span>
                                        @endif
                                        <a href="{{ route('products.show', $product) }}" class="font-medium text-indigo-600 hover:text-indigo-900 hover:underline">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($product->description, 50) ?: '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                    {{ number_format($product->price, 0, ',', ' ') }} {{ $product->currency }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php($qty = $product->quantity)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $qty <= 0 ? 'bg-red-100 text-red-800' : ($qty < 5 ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $qty }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 transition">
                                            {{ __('Edit') }}
                                        </a>

                                        <form method="POST"
                                            action="{{ route('products.destroy', $product) }}"
                                            onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $products->links() }}
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>