<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Security Authorization</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                {{-- Header bar --}}
                <div class="bg-gray-700 text-white px-6 py-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span class="font-semibold tracking-wide">Page Access Rights Configuration</span>
                </div>

                {{-- Role legend --}}
                <div class="px-6 py-3 bg-gray-50 border-b flex gap-6 text-sm">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>
                        <strong>Admin</strong> — always full access (locked)
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>
                        <strong>Supervisor</strong>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span>
                        <strong>Operator</strong>
                    </span>
                </div>

                <form method="POST" action="{{ route('authorization.update') }}">
                    @csrf
                    @method('PUT')

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Screen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-red-500 uppercase tracking-wider">Admin</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-yellow-600 uppercase tracking-wider">Supervisor</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-green-600 uppercase tracking-wider">Operator</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($permissions as $perm)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-xs text-gray-400 font-mono">P{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 text-sm">{{ $perm->label }}</div>
                                    <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $perm->key }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $perm->description }}</td>

                                {{-- Admin: always locked ON --}}
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox" checked disabled
                                        class="w-4 h-4 rounded border-gray-300 text-red-500 cursor-not-allowed opacity-60">
                                </td>

                                {{-- Supervisor --}}
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox"
                                        name="supervisor[{{ str_replace('.', '_', $perm->key) }}]"
                                        value="1"
                                        {{ $perm->supervisor ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-yellow-500 focus:ring-yellow-400 cursor-pointer">
                                </td>

                                {{-- Operator --}}
                                <td class="px-6 py-4 text-center">
                                    <input type="checkbox"
                                        name="operator[{{ str_replace('.', '_', $perm->key) }}]"
                                        value="1"
                                        {{ $perm->operator ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-green-500 focus:ring-green-400 cursor-pointer">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4 bg-gray-50 border-t flex items-center gap-3">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 font-medium text-sm">
                            Save Permissions
                        </button>
                        <span class="text-xs text-gray-400">Changes take effect immediately for all users.</span>
                    </div>
                </form>
            </div>

            {{-- Info box --}}
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded p-4 text-sm text-blue-700">
                <strong>Note:</strong> Admin always has full access to all pages and cannot be restricted.
                User Management and this Authorization page are always Admin-only.
            </div>
        </div>
    </div>
</x-app-layout>
