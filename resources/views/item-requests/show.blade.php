<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Issue Detail</h2>
            <a href="{{ route('item-requests.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm">← Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
                    @endif

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Status</p>
                            <span class="inline-block px-2 py-1 text-xs rounded font-semibold mt-1
                                {{ $itemRequest->status === 'approved' ? 'bg-green-100 text-green-700' :
                                   ($itemRequest->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($itemRequest->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Requested By</p>
                            <p class="mt-1 font-medium">{{ $itemRequest->requester->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Item</p>
                            <p class="mt-1 font-medium">[{{ $itemRequest->item->code }}] {{ $itemRequest->item->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Quantity Requested</p>
                            <p class="mt-1 font-medium">{{ number_format($itemRequest->quantity_requested, 2) }} {{ $itemRequest->item->unit }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Vendor</p>
                            <p class="mt-1">{{ $itemRequest->vendor_name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Expiry Date</p>
                            @if($itemRequest->expiry_date)
                                @php $daysLeft = now()->startOfDay()->diffInDays($itemRequest->expiry_date, false); @endphp
                                <p class="mt-1 font-medium {{ $daysLeft < 0 ? 'text-red-600' : ($daysLeft <= 90 ? 'text-orange-500' : '') }}">
                                    {{ $itemRequest->expiry_date->format('d M Y') }}
                                    @if($daysLeft < 0) <span class="text-xs">(Expired)</span>
                                    @elseif($daysLeft <= 90) <span class="text-xs">({{ $daysLeft }}d left)</span>
                                    @endif
                                </p>
                            @else
                                <p class="mt-1 text-gray-400">—</p>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Purpose</p>
                            <p class="mt-1">{{ $itemRequest->purpose }}</p>
                        </div>
                        @if($itemRequest->notes)
                        <div class="col-span-2">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Notes</p>
                            <p class="mt-1 text-gray-600">{{ $itemRequest->notes }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Submitted At</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $itemRequest->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if($itemRequest->reviewer)
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Reviewed By</p>
                            <p class="mt-1 font-medium">{{ $itemRequest->reviewer->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Reviewed At</p>
                            <p class="mt-1 text-sm text-gray-600">{{ \Carbon\Carbon::parse($itemRequest->reviewed_at)->format('d M Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
