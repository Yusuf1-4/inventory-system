<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Stock Issues</h2>
            <a href="{{ route('item-requests.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ New Stock Issue</a>
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
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Item</th>
                                <th class="px-4 py-3">Lot No</th>
                                <th class="px-4 py-3 text-right">Qty Requested</th>
                                <th class="px-4 py-3">Vendor</th>
                                <th class="px-4 py-3">Expiry Date</th>
                                <th class="px-4 py-3">Purpose</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Reviewed By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($requests as $req)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $req->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 font-medium">
                                    <a href="{{ route('items.show', $req->item) }}" class="text-indigo-600 hover:underline">{{ $req->item->name }}</a>
                                </td>
                                <td class="px-4 py-3">{{ $req->lot_number ?? '—' }}</td>
                                <td class="px-4 py-3 text-right font-semibold">{{ $req->quantity_requested }} {{ $req->item->unit }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $req->vendor_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($req->expiry_date)
                                        @php $dl = now()->startOfDay()->diffInDays($req->expiry_date, false); @endphp
                                        <span class="{{ $dl < 0 ? 'text-red-600' : ($dl <= 90 ? 'text-orange-500' : 'text-gray-700') }}">
                                            {{ $req->expiry_date->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $req->purpose }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded text-xs font-semibold
                                        @if($req->status === 'approved') bg-green-100 text-green-700
                                        @elseif($req->status === 'rejected') bg-red-100 text-red-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ ucfirst($req->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-400">{{ $req->reviewer?->name ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-400">You have no stock issues yet. <a href="{{ route('item-requests.create') }}" class="text-indigo-600 hover:underline">Submit a stock issue</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $requests->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
