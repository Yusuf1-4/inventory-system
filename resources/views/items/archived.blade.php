<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Archived Items</h2>
                <p class="text-sm text-gray-500 mt-0.5">Items removed from active lists. Unarchive to make them available again.</p>
            </div>
            <a href="{{ route('items.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm">
                ← Back to Active Items
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Code</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3">Unit</th>
                                <th class="px-4 py-3 text-right">Quantity</th>
                                <th class="px-4 py-3">Archived At</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $item)
                            <tr class="hover:bg-gray-50 opacity-75">
                                <td class="px-4 py-3 font-mono text-gray-500">{{ $item->code }}</td>
                                <td class="px-4 py-3 font-medium text-gray-700">{{ $item->name }}</td>
                                <td class="px-4 py-3 text-gray-500 text-sm">
                                    @forelse($item->suppliers as $s)
                                        <span class="inline-block bg-gray-100 text-gray-600 rounded px-2 py-0.5 text-xs mr-1 mb-1">{{ $s->supplier_name }}</span>
                                    @empty
                                        <span class="text-gray-300">—</span>
                                    @endforelse
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $item->unit }}</td>
                                <td class="px-4 py-3 text-right text-gray-500">{{ number_format($item->quantity, 2) }}</td>
                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $item->archived_at?->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:underline">View</a>
                                    @if(Auth::user()->canAccess('items.manage'))
                                    <form method="POST" action="{{ route('items.unarchive', $item) }}"
                                          onsubmit="return confirm('Restore [{{ $item->code }}] to active items?')">
                                        @csrf
                                        <button class="text-green-600 hover:underline">Unarchive</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                    No archived items.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $items->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
