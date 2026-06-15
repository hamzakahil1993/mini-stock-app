<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('products._form', ['product' => $product])

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>
                            <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>