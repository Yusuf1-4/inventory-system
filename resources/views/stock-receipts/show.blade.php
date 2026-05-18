<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Receipt Detail</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">

                {{-- Type badge --}}
                <div class="mb-1">
                    @if($stockReceipt->type === 'production')
                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">Production Return</span>
                    @else
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Received from Supplier</span>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div><div class="text-xs text-gray-500">Item</div><div class="font-semibold">{{ $stockReceipt->item->name }}</div></div>
                    <div><div class="text-xs text-gray-500">Item Code</div><div class="font-mono">{{ $stockReceipt->item->code }}</div></div>
                    <div>
                        <div class="text-xs text-gray-500">Quantity Received</div>
                        <div class="{{ $stockReceipt->type === 'production' ? 'text-blue-600' : 'text-green-600' }} font-bold text-lg">
                            +{{ $stockReceipt->quantity }} {{ $stockReceipt->item->unit }}
                        </div>
                    </div>

                    @if($stockReceipt->type === 'production')
                    <div>
                        <div class="text-xs text-gray-500">Original Request</div>
                        @if($stockReceipt->itemRequest)
                        <a href="{{ route('item-requests.show', $stockReceipt->itemRequest) }}" class="text-blue-600 hover:underline font-mono text-sm">
                            Request #{{ $stockReceipt->item_request_id }}
                        </a>
                        @if($stockReceipt->itemRequest->requester)
                        <div class="text-xs text-gray-400">by {{ $stockReceipt->itemRequest->requester->name }}</div>
                        @endif
                        @else
                        <div class="text-gray-400">—</div>
                        @endif
                    </div>
                    @else
                    <div><div class="text-xs text-gray-500">Supplier</div><div>{{ $stockReceipt->supplier_name }}</div></div>
                    <div>
                        <div class="text-xs text-gray-500">Lot No</div>
                        <div class="font-mono font-semibold text-indigo-700">{{ $stockReceipt->lot_number ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Expiry Date</div>
                        @if($stockReceipt->expiry_date)
                            @php $daysLeft = now()->startOfDay()->diffInDays($stockReceipt->expiry_date, false); @endphp
                            <div class="font-medium {{ $daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 90 ? 'text-orange-500' : 'text-gray-800') }}">
                                {{ $stockReceipt->expiry_date->format('d M Y') }}
                                @if($daysLeft < 0) <span class="text-xs ml-1">(Expired)</span>
                                @elseif($daysLeft <= 90) <span class="text-xs ml-1">({{ $daysLeft }} days left)</span>
                                @endif
                            </div>
                        @else
                            <div class="text-gray-400">—</div>
                        @endif
                    </div>
                    @endif

                    <div><div class="text-xs text-gray-500">{{ $stockReceipt->type === 'production' ? 'Return Date' : 'Received Date' }}</div><div>{{ $stockReceipt->received_date->format('d M Y') }}</div></div>
                    <div><div class="text-xs text-gray-500">Recorded By</div><div>{{ $stockReceipt->receiver->name }}</div></div>
                    <div class="col-span-2"><div class="text-xs text-gray-500">Notes</div><div>{{ $stockReceipt->notes ?? '-' }}</div></div>
                </div>

                <div class="pt-4 border-t">
                    <a href="{{ route('stock-receipts.index', ['type' => $stockReceipt->type]) }}" class="text-gray-500 hover:underline text-sm">&larr; Back to Stock Received</a>
                </div>

                @if($stockReceipt->isFromSupplier() && $batchSummary && $batchSummary['total'] > 0)
                <div class="pt-4 border-t mt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Batch Summary</h3>
                    <div class="flex gap-4 mb-4">
                        <div class="bg-gray-50 rounded-lg px-5 py-3 text-center">
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($batchSummary['total']) }}</div>
                            <div class="text-xs text-gray-500 mt-1">Total Batches</div>
                        </div>
                        <div class="bg-green-50 rounded-lg px-5 py-3 text-center">
                            <div class="text-2xl font-bold text-green-700">{{ number_format($batchSummary['available']) }}</div>
                            <div class="text-xs text-gray-500 mt-1">Available</div>
                        </div>
                        <div class="bg-red-50 rounded-lg px-5 py-3 text-center">
                            <div class="text-2xl font-bold text-red-600">{{ number_format($batchSummary['issued']) }}</div>
                            <div class="text-xs text-gray-500 mt-1">Issued</div>
                        </div>
                    </div>
                    <a href="{{ route('stock-receipts.batches', $stockReceipt) }}"
                        class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">
                        View All Batch Numbers &rarr;
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

