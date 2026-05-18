<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Item: {{ $item->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('stock-receipts.create') }}?item_id={{ $item->id }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">+ Receive Stock</a>
                @if(Auth::user()->canAccess('stock-batches.view'))
                <a href="{{ route('stock-batches.index', ['item_id' => $item->id]) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">Stock Batches</a>
                @endif
                @if(Auth::user()->canAccess('items.manage'))
                <a href="{{ route('items.edit', $item) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">Edit</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info Card --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div><div class="text-xs text-gray-500">Code</div><div class="font-mono font-semibold">{{ $item->code }}</div></div>
                <div class="sm:col-span-2">
                    <div class="text-xs text-gray-500 mb-1">Suppliers</div>
                    @forelse($item->suppliers as $s)
                        <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full px-3 py-0.5 text-xs mr-1 mb-1">{{ $s->supplier_name }}</span>
                    @empty
                        <span class="text-gray-400 text-sm">—</span>
                    @endforelse
                </div>
                <div><div class="text-xs text-gray-500">Unit</div><div>{{ $item->unit }}</div></div>
                <div><div class="text-xs text-gray-500">Current Stock</div>
                    <div class="text-2xl font-bold {{ $item->quantity <= 10 ? 'text-red-600' : 'text-green-600' }}">
                        {{ number_format($item->quantity, 2) }}
                    </div>
                </div>
                <div><div class="text-xs text-gray-500">Description</div><div class="text-sm">{{ $item->description ?? '-' }}</div></div>
            </div>

            {{-- Stock Received from Supplier --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-green-700">Stock Received from Supplier</h3>
                @php
                    $supplierReceipts = $item->stockReceipts->where('type', 'supplier')->sortBy([['supplier_name','asc'],['expiry_date','asc']]);
                @endphp
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Supplier</th>
                            <th class="px-4 py-3 text-left">Batch No.</th>
                            <th class="px-4 py-3 text-left">Expiry Date</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-left">Received By</th>
                            <th class="px-4 py-3 text-left">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($supplierReceipts as $receipt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $receipt->received_date->format('d M Y') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block bg-blue-50 text-blue-700 rounded px-2 py-0.5 text-xs">{{ $receipt->supplier_name }}</span>
                            </td>
                            <td class="px-4 py-2 font-mono text-xs text-gray-600">{{ $receipt->batch_number ?? '—' }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($receipt->expiry_date)
                                    @php $daysLeft = now()->startOfDay()->diffInDays($receipt->expiry_date, false); @endphp
                                    <span class="font-medium {{ $daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 90 ? 'text-orange-500' : 'text-gray-700') }}">
                                        {{ $receipt->expiry_date->format('d M Y') }}
                                    </span>
                                    @if($daysLeft < 0)
                                        <span class="ml-1 text-xs bg-red-100 text-red-600 rounded px-1">Expired</span>
                                    @elseif($daysLeft <= 90)
                                        <span class="ml-1 text-xs bg-orange-100 text-orange-600 rounded px-1">{{ $daysLeft }}d left</span>
                                    @endif
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right text-green-600 font-semibold">+{{ number_format($receipt->quantity, 2) }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ $receipt->receiver->name }}</td>
                            <td class="px-4 py-2 text-gray-400 text-xs">{{ $receipt->notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-4 text-center text-gray-400">No supplier receipts yet.</td></tr>
                        @endforelse
                    </tbody>
                    @if($supplierReceipts->count() > 1)
                    <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                        @foreach($supplierReceipts->groupBy('supplier_name') as $supplierName => $recs)
                        <tr class="text-xs text-gray-500">
                            <td colspan="4" class="px-4 py-2 text-right italic">Subtotal — {{ $supplierName }}</td>
                            <td class="px-4 py-2 text-right font-semibold text-gray-700">{{ number_format($recs->sum('quantity'), 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                        @endforeach
                        <tr class="text-sm font-bold border-t border-gray-300">
                            <td colspan="4" class="px-4 py-2 text-right">Total from Suppliers</td>
                            <td class="px-4 py-2 text-right text-green-700">{{ number_format($supplierReceipts->sum('quantity'), 2) }} {{ $item->unit }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- Stock Returned from Production --}}
            @php
                $productionReceipts = $item->stockReceipts->where('type', 'production')->sortByDesc('received_date');
            @endphp
            @if($productionReceipts->count() > 0 || true)
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4 text-indigo-700">Returned from Production</h3>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Return Date</th>
                            <th class="px-4 py-3 text-left">Original Request</th>
                            <th class="px-4 py-3 text-right">Qty Returned</th>
                            <th class="px-4 py-3 text-left">Returned By</th>
                            <th class="px-4 py-3 text-left">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($productionReceipts as $receipt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $receipt->received_date->format('d M Y') }}</td>
                            <td class="px-4 py-2">
                                @if($receipt->item_request_id)
                                <a href="{{ route('item-requests.show', $receipt->item_request_id) }}" class="text-blue-600 hover:underline font-mono text-xs">#{{ $receipt->item_request_id }}</a>
                                @else
                                <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right text-indigo-600 font-semibold">+{{ number_format($receipt->quantity, 2) }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ $receipt->receiver->name }}</td>
                            <td class="px-4 py-2 text-gray-400 text-xs">{{ $receipt->notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">No production returns yet.</td></tr>
                        @endforelse
                    </tbody>
                    @if($productionReceipts->count() > 0)
                    <tfoot class="border-t-2 border-gray-200 bg-gray-50">
                        <tr class="text-sm font-bold">
                            <td colspan="2" class="px-4 py-2 text-right">Total from Production</td>
                            <td class="px-4 py-2 text-right text-indigo-700">{{ number_format($productionReceipts->sum('quantity'), 2) }} {{ $item->unit }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
            @endif

            {{-- Item Requests --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Usage Requests</h3>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Date</th>
                            <th class="px-4 py-3 text-left">Requested By</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-left">Purpose</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($item->itemRequests as $req)
                        <tr>
                            <td class="px-4 py-2">{{ $req->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ $req->requester->name }}</td>
                            <td class="px-4 py-2 text-right text-red-600 font-semibold">-{{ $req->quantity_requested }}</td>
                            <td class="px-4 py-2">{{ $req->purpose }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @if($req->status === 'approved') bg-green-100 text-green-700
                                    @elseif($req->status === 'rejected') bg-red-100 text-red-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">No requests for this item.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('items.index') }}" class="inline-block text-gray-500 hover:underline text-sm">&larr; Back to Item Master</a>
        </div>
    </div>
</x-app-layout>
