<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Clients') }}
            </h2>
            <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Add Client') }}
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
                @if ($clients->isEmpty())
                <div class="p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">{{ __('No clients yet.') }}</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Phone') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($clients as $client)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">
                                            {{ strtoupper(Str::substr($client->name, 0, 1)) }}
                                        </span>
                                        <span class="font-medium text-gray-900">{{ $client->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <a href="mailto:{{ $client->email }}" class="hover:text-indigo-600 hover:underline">{{ $client->email }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $client->phone ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($client->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                        {{ __('Active') }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                        {{ __('Inactive') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('clients.edit', $client) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 transition">
                                            {{ __('Edit') }}
                                        </a>

                                        <form method="POST"
                                            action="{{ route('clients.destroy', $client) }}"
                                            onsubmit="return confirm('{{ __('Are you sure you want to delete this client?') }}')">
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

                @if ($clients->hasPages())
                <div class="border-t border-gray-200 px-6 py-4">
                    {{ $clients->links() }}
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>