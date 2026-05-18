<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Quick Actions --}}
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('items.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Add Item
                </a>
                <a href="{{ route('stock-receipts.create') }}"
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Receive Stock from Supplier
                </a>
                <a href="{{ route('item-requests.create') }}"
                   class="inline-flex items-center gap-2 bg-yellow-500 text-white px-5 py-2.5 rounded-lg hover:bg-yellow-600 font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    New Item Request
                </a>
                <a href="{{ route('items.index') }}"
                   class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-50 font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    View All Items
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Items</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $totalItems }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Stock (all items)</div>
                    <div class="text-3xl font-bold text-green-600">{{ number_format($totalStock, 2) }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Pending Requests</div>
                    <div class="text-3xl font-bold text-yellow-600">{{ $pendingRequests }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Low Stock Items (&le;10)</div>
                    <div class="text-3xl font-bold text-red-600">{{ $lowStockItems }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Recent Requests --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Recent Item Requests</h3>
                        @forelse($recentRequests as $req)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <div class="font-medium">{{ $req->item->name }}</div>
                                <div class="text-sm text-gray-500">by {{ $req->requester->name }} &bull; {{ $req->quantity_requested }} {{ $req->item->unit }}</div>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($req->status === 'approved') bg-green-100 text-green-700
                                @elseif($req->status === 'rejected') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                {{ ucfirst($req->status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm">No requests yet.</p>
                        @endforelse
                        <div class="mt-4">
                            <a href="{{ route('item-requests.admin') }}" class="text-indigo-600 text-sm hover:underline">View all requests &rarr;</a>
                        </div>
                    </div>
                </div>

                {{-- Recent Stock Receipts --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Recent Stock Receipts</h3>
                        @forelse($recentReceipts as $receipt)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <div class="font-medium">{{ $receipt->item->name }}</div>
                                <div class="text-sm text-gray-500">{{ $receipt->supplier_name }} &bull; {{ $receipt->received_date->format('d M Y') }}</div>
                            </div>
                            <span class="text-green-600 font-semibold">+{{ $receipt->quantity }} {{ $receipt->item->unit }}</span>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm">No receipts yet.</p>
                        @endforelse
                        <div class="mt-4">
                            <a href="{{ route('stock-receipts.index') }}" class="text-indigo-600 text-sm hover:underline">View all receipts &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
