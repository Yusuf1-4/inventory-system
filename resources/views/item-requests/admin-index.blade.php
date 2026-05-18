<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage All Stock Issues</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Requested By</th>
                                <th class="px-4 py-3">Item</th>
                                <th class="px-4 py-3 text-right">Qty</th>
                                <th class="px-4 py-3 text-right">Available</th>
                                <th class="px-4 py-3">Vendor</th>
                                <th class="px-4 py-3">Expiry Date</th>
                                <th class="px-4 py-3">Purpose</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($requests as $req)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $req->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 font-medium">{{ $req->requester->name }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('items.show', $req->item) }}" class="text-indigo-600 hover:underline">{{ $req->item->name }}</a>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold">{{ $req->quantity_requested }} {{ $req->item->unit }}</td>
                                <td class="px-4 py-3 text-right {{ $req->item->quantity < $req->quantity_requested ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                    {{ $req->item->quantity }} {{ $req->item->unit }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $req->vendor_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($req->expiry_date)
                                        @php $dl = now()->startOfDay()->diffInDays($req->expiry_date, false); @endphp
                                        <span class="{{ $dl < 0 ? 'text-red-600 font-semibold' : ($dl <= 90 ? 'text-orange-500' : 'text-gray-700') }}">
                                            {{ $req->expiry_date->format('d M Y') }}
                                            @if($dl < 0) <span class="text-xs">(Expired)</span>
                                            @elseif($dl <= 90) <span class="text-xs">({{ $dl }}d)</span>
                                            @endif
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
                                <td class="px-4 py-3">
                                    @if($req->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('item-requests.approve', $req) }}">
                                            @csrf
                                            <button class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('item-requests.reject', $req) }}">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">Reject</button>
                                        </form>
                                    </div>
                                    @else
                                    <span class="text-gray-400 text-xs">
                                        {{ $req->reviewer?->name ?? '' }}
                                        @if($req->reviewed_at)
                                        <br>{{ $req->reviewed_at->format('d M Y') }}
                                        @endif
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="px-4 py-6 text-center text-gray-400">No stock issues found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $requests->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
