<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Backup &amp; Export</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="bg-gray-700 text-white px-6 py-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span class="font-semibold tracking-wide">Data Export (CSV)</span>
                </div>
                <p class="px-6 pt-4 pb-2 text-sm text-gray-500">
                    Download a snapshot of each data table as a CSV file. Files are UTF-8 encoded and open correctly in Excel.
                </p>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Set</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Records</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @php
                            $exports = [
                                ['type' => 'items',          'label' => 'Item Master',      'desc' => 'All items including archived, with suppliers and quantities.'],
                                ['type' => 'stock-receipts', 'label' => 'Stock Receipts',   'desc' => 'All recorded stock received from suppliers.'],
                                ['type' => 'item-requests',  'label' => 'Item Requests',    'desc' => 'All item requests with status, approvals and rejections.'],
                                ['type' => 'users',          'label' => 'Users',            'desc' => 'User accounts with roles (passwords excluded).'],
                                ['type' => 'audit-logs',     'label' => 'Audit Trail',      'desc' => 'Full activity log of all user actions.'],
                            ];
                        @endphp

                        @foreach($exports as $exp)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $exp['label'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $exp['desc'] }}</td>
                            <td class="px-6 py-4 text-right text-sm text-gray-600 font-mono">
                                {{ number_format($counts[$exp['type']]) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('backup.download', $exp['type']) }}"
                                   class="inline-flex items-center gap-1.5 bg-indigo-600 text-white px-4 py-1.5 rounded text-sm hover:bg-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download CSV
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-3 bg-gray-50 border-t text-xs text-gray-400">
                    All downloads are logged in the Audit Trail.
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
