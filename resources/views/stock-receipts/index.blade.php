<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Received</h2>
            <div class="flex gap-2">
                @if(Auth::user()->canAccess('stock-receipts.create'))
                @if($type === 'production')
                <a href="{{ route('stock-receipts.return.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ Return from Production</a>
                @else
                <a href="{{ route('stock-receipts.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">+ Receive from Supplier</a>
                @endif
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            {{-- Type tabs --}}
            <div class="flex gap-0 mb-0 border-b border-gray-200">
                <a href="{{ route('stock-receipts.index', ['type' => 'supplier']) }}"
                    class="px-6 py-2 text-sm font-medium border-b-2 -mb-px transition
                        {{ $type === 'supplier' ? 'border-green-500 text-green-700 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    From Supplier
                </a>
                <a href="{{ route('stock-receipts.index', ['type' => 'production']) }}"
                    class="px-6 py-2 text-sm font-medium border-b-2 -mb-px transition
                        {{ $type === 'production' ? 'border-gray-700 text-gray-900 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    From Production
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-t-none sm:rounded-b-lg">
                <div class="p-6">
                    @if($type === 'supplier')
                    {{-- ── SUPPLIER RECEIPTS TABLE ────────────────────────────────── --}}
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm text-left whitespace-nowrap">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Item</th>
                                    <th class="px-4 py-3">Supplier</th>
                                    <th class="px-4 py-3">GRN No</th>
                                    <th class="px-4 py-3">Lot No</th>
                                    <th class="px-4 py-3">Expiry Date</th>
                                    <th class="px-4 py-3 text-right">Qty Received</th>
                                    <th class="px-4 py-3">Received By</th>
                                    <th class="px-4 py-3">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($receipts as $receipt)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <a href="{{ route('stock-receipts.show', $receipt) }}" class="text-indigo-600 hover:underline text-xs">
                                            {{ $receipt->received_date->format('d M Y') }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 font-medium">
                                        <a href="{{ route('items.show', $receipt->item) }}" class="text-indigo-600 hover:underline">{{ $receipt->item->name }}</a>
                                        <div class="text-xs text-gray-400">{{ $receipt->item->code }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ $receipt->supplier_name }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $receipt->grn_number ?? '-' }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-indigo-700 font-semibold">{{ $receipt->lot_number ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($receipt->expiry_date)
                                            @php $daysLeft = now()->startOfDay()->diffInDays($receipt->expiry_date, false); @endphp
                                            <span class="font-medium {{ $daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 90 ? 'text-orange-500' : 'text-gray-700') }}">
                                                {{ $receipt->expiry_date->format('d M Y') }}
                                            </span>
                                            @if($daysLeft < 0)
                                                <span class="ml-2 text-xs bg-red-100 text-red-600 rounded px-1.5 py-0.5">Expired</span>
                                            @elseif($daysLeft <= 90)
                                                <span class="ml-2 text-xs bg-orange-100 text-orange-600 rounded px-1.5 py-0.5">{{ $daysLeft }}d left</span>
                                            @endif
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right text-green-600 font-semibold">+{{ number_format($receipt->quantity, 2) }} {{ $receipt->item->unit }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $receipt->receiver->name }}</td>
                                    <td class="px-4 py-3 text-gray-400 max-w-xs truncate" title="{{ $receipt->notes }}">
                                        {{ $receipt->notes ?? '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="9" class="px-4 py-6 text-center text-gray-400">No supplier receipts yet. <a href="{{ route('stock-receipts.create') }}" class="text-indigo-600 hover:underline">Record first receipt</a></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @else
                    {{-- ── PRODUCTION RETURNS TABLE ───────────────────────────────── --}}
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Return Date</th>
                                <th class="px-4 py-3">Request #</th>
                                <th class="px-4 py-3">Item</th>
                                <th class="px-4 py-3 text-right">Qty Returned</th>
                                <th class="px-4 py-3">Returned By</th>
                                <th class="px-4 py-3">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($receipts as $receipt)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('stock-receipts.show', $receipt) }}" class="text-indigo-600 hover:underline text-xs">
                                        {{ $receipt->received_date->format('d M Y') }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    @if($receipt->itemRequest)
                                    <a href="{{ route('item-requests.show', $receipt->itemRequest) }}" class="text-blue-600 hover:underline text-xs font-mono">#{{ $receipt->item_request_id }}</a>
                                    @else
                                    <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium">
                                    <a href="{{ route('items.show', $receipt->item) }}" class="text-indigo-600 hover:underline">{{ $receipt->item->name }}</a>
                                    <div class="text-xs text-gray-400">{{ $receipt->item->code }}</div>
                                </td>
                                <td class="px-4 py-3 text-right text-indigo-600 font-semibold">+{{ number_format($receipt->quantity, 2) }} {{ $receipt->item->unit }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $receipt->receiver->name }}</td>
                                <td class="px-4 py-3 text-gray-400">{{ $receipt->notes ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">No production returns yet. <a href="{{ route('stock-receipts.return.create') }}" class="text-indigo-600 hover:underline">Record first return</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endif

                    <div class="mt-4">{{ $receipts->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

