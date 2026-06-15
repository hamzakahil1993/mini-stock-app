<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Back to products') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Price') }}</dt>
                    <dd class="mt-2 text-2xl font-bold text-gray-900">
                        {{ number_format($product->price, 0, ',', ' ') }}
                        <span class="text-base font-medium text-gray-500">{{ $product->currency }}</span>
                    </dd>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Current quantity') }}</dt>
                    <dd class="mt-2">
                        @php($qty = $product->quantity)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold
                            {{ $qty <= 0 ? 'bg-red-100 text-red-800' : ($qty < 5 ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800') }}">
                            {{ $qty }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-200 rounded-xl p-5">
                    <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Stock movements') }}</dt>
                    <dd class="mt-2 text-2xl font-bold text-gray-900">{{ $stockMovements->count() }}</dd>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm ring-1 ring-gray-200 rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Product details') }}</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @if ($product->image)
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">{{ __('Image') }}</dt>
                                <dd class="mt-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-40 w-40 rounded-lg object-cover ring-1 ring-gray-200">
                                </dd>
                            </div>
                        @endif
                        <div class="{{ $product->image ? 'sm:col-span-2' : 'sm:col-span-3' }}">
                            <dt class="text-sm font-medium text-gray-500">{{ __('Description') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->description ?: '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm ring-1 ring-gray-200 rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Stock movements') }}</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full table-fixed divide-y divide-gray-200">
                        <colgroup>
                            <col class="w-[30%]">
                            <col class="w-[20%]">
                            <col class="w-[20%]">
                            <col class="w-[30%]">
                        </colgroup>
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Quantity') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Running total') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php($runningTotal = 0)
                            @forelse ($stockMovements as $movement)
                            @php($runningTotal += $movement->quantity)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($movement->type === 'IN')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                        {{ __('IN') }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        {{ __('OUT') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold {{ $movement->quantity > 0 ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">{{ $runningTotal }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                    {{ __('No stock movements yet.') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>