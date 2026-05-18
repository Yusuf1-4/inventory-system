<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Card Report</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Item Filter --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('stock-card.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[260px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Item</label>
                        <select name="item_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select an item --</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ (request('item_id') == $item->id) ? 'selected' : '' }}>
                                [{{ $item->code }}] {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 text-sm">
                            View Card
                        </button>
                        @if(request('item_id'))
                        <a href="{{ route('stock-card.index') }}" class="ml-2 bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            @if($selectedItem)
            {{-- Item Info Header --}}
            <div class="bg-indigo-50 border border-indigo-200 sm:rounded-lg p-4 mb-4 flex flex-wrap gap-6">
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Item Code</p>
                    <p class="font-semibold text-gray-800">{{ $selectedItem->code }}</p>
                </div>
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Item Name</p>
                    <p class="font-semibold text-gray-800">{{ $selectedItem->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Unit</p>
                    <p class="font-semibold text-gray-800">{{ $selectedItem->unit }}</p>
                </div>
                <div>
                    <p class="text-xs text-indigo-500 uppercase font-semibold">Current Balance</p>
                    <p class="font-bold text-indigo-700 text-lg">{{ number_format($selectedItem->quantity, 2) }} {{ $selectedItem->unit }}</p>
                </div>
            </div>

            {{-- Stock Card Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($movements->isEmpty())
                    <p class="text-center text-gray-400 py-8">No movement history found for this item.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 whitespace-nowrap">Date</th>
                                    <th class="px-4 py-3 whitespace-nowrap">MR No</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Batch No</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Expiry Date</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">IN</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">OUT</th>
                                    <th class="px-4 py-3 text-right whitespace-nowrap">Balance</th>
                                    <th class="px-4 py-3">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($movements as $m)
                                <tr class="hover:bg-gray-50
                                    {{ $m['type'] === 'out' ? 'bg-red-50/30' : ($m['type'] === 'return' ? 'bg-blue-50/30' : '') }}">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-700">
                                        {{ $m['date'] instanceof \Carbon\Carbon ? $m['date']->format('d M Y') : \Carbon\Carbon::parse($m['date'])->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($m['mr_no'] !== '—')
                                            <span class="font-mono text-indigo-700 font-semibold">{{ $m['mr_no'] }}</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($m['batch_no'] !== '—')
                                            <span class="font-mono text-gray-700">{{ $m['batch_no'] }}</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($m['expiry_date'])
                                            @php
                                                $ed = $m['expiry_date'] instanceof \Carbon\Carbon
                                                    ? $m['expiry_date']
                                                    : \Carbon\Carbon::parse($m['expiry_date']);
                                                $dl = now()->startOfDay()->diffInDays($ed, false);
                                            @endphp
                                            <span class="{{ $dl < 0 ? 'text-red-600 font-semibold' : ($dl <= 90 ? 'text-orange-500' : 'text-gray-700') }}">
                                                {{ $ed->format('d M Y') }}
                                                @if($dl < 0)<span class="text-xs"> (Expired)</span>
                                                @elseif($dl <= 90)<span class="text-xs"> ({{ $dl }}d)</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        @if($m['in'])
                                            <span class="text-green-700 font-semibold">+{{ number_format($m['in'], 2) }}</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        @if($m['out'])
                                            <span class="text-red-600 font-semibold">-{{ number_format($m['out'], 2) }}</span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap font-bold
                                        {{ $m['balance'] < 0 ? 'text-red-600' : 'text-gray-800' }}">
                                        {{ number_format($m['balance'], 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 max-w-xs truncate" title="{{ $m['remarks'] }}">
                                        {{ $m['remarks'] ?: '—' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-xs text-gray-500 uppercase font-semibold">Total</td>
                                    <td class="px-4 py-3 text-right text-green-700 font-bold">
                                        +{{ number_format($movements->sum(fn($m) => $m['in'] ?? 0), 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-red-600 font-bold">
                                        -{{ number_format($movements->sum(fn($m) => $m['out'] ?? 0), 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-800">
                                        {{ number_format($movements->last()['balance'] ?? 0, 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            @elseif(request()->has('item_id'))
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-700 px-4 py-3 rounded">
                Item not found.
            </div>
            @else
            <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center text-gray-400">
                Select an item above to view its stock card history.
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
