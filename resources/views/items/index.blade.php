<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Item Master</h2>
            <div class="flex gap-2">
                @if(Auth::user()->canAccess('items.manage'))
                <button id="btn-delete-selected" onclick="confirmBulkDelete()"
                    class="hidden bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">&#128465; Delete Selected (<span id="selected-count">0</span>)</button>
                <a href="{{ route('items.archived') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">&#128230; Archived</a>
                <a href="{{ route('items.bulk-import.form') }}" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">&#8618; Bulk Import</a>
                <a href="{{ route('items.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">+ Add Item</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="bulk-delete-form" method="POST" action="{{ route('items.bulk-delete') }}">
                        @csrf @method('DELETE')

                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                @if(Auth::user()->canAccess('items.manage'))
                                <th class="px-4 py-3 w-8">
                                    <input type="checkbox" id="check-all" class="rounded border-gray-300 text-indigo-600 cursor-pointer" title="Select all">
                                </th>
                                @endif
                                <th class="px-4 py-3">Code</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3 text-right">Received Qty</th>
                                <th class="px-4 py-3">Expiry Dates</th>
                                <th class="px-4 py-3">Unit</th>
                                <th class="px-4 py-3 text-right">Current Stock</th>
                                <th class="px-4 py-3">Created By</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                @php
                                    $receiptsBySupplier = $item->stockReceipts
                                        ->groupBy('supplier_name')
                                        ->map(fn($recs) => [
                                            'qty'    => $recs->sum('quantity'),
                                            'expiry' => $recs->pluck('expiry_date')
                                                ->filter()
                                                ->map(fn($d) => $d->format('d M Y'))
                                                ->unique()->sort()->values(),
                                        ]);
                                    $allVendors = $item->suppliers->pluck('supplier_name')
                                        ->merge($receiptsBySupplier->keys())
                                        ->unique()->values();
                                    if ($allVendors->isEmpty()) { $allVendors = collect([null]); }
                                    $rowCount = $allVendors->count();
                                @endphp
                                @foreach($allVendors as $vIdx => $vendorName)
                                <tr class="hover:bg-gray-50 {{ $vIdx === 0 ? 'border-t-2 border-gray-300 row-item' : 'border-t border-gray-100' }}">
                                    @if($vIdx === 0)
                                        @if(Auth::user()->canAccess('items.manage'))
                                        <td class="px-4 py-3 align-top" rowspan="{{ $rowCount }}">
                                            <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="row-check rounded border-gray-300 text-indigo-600 cursor-pointer mt-1">
                                        </td>
                                        @endif
                                        <td class="px-4 py-3 font-mono align-top" rowspan="{{ $rowCount }}">{{ $item->code }}</td>
                                        <td class="px-4 py-3 font-medium align-top" rowspan="{{ $rowCount }}">{{ $item->name }}</td>
                                    @endif
                                    <td class="px-4 py-3 text-sm">
                                        @if($vendorName)
                                            <span class="inline-block bg-blue-50 text-blue-700 rounded px-2 py-0.5 text-xs">{{ $vendorName }}</span>
                                        @else
                                            <span class="text-gray-300">&mdash;</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right font-mono text-sm text-gray-600">
                                        @if($vendorName && isset($receiptsBySupplier[$vendorName]))
                                            {{ number_format($receiptsBySupplier[$vendorName]['qty'], 2) }}
                                        @else
                                            <span class="text-gray-300">&mdash;</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs">
                                        @if($vendorName && isset($receiptsBySupplier[$vendorName]) && $receiptsBySupplier[$vendorName]['expiry']->isNotEmpty())
                                            <div class="flex flex-wrap gap-1">
                                            @foreach($receiptsBySupplier[$vendorName]['expiry'] as $expDate)
                                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 rounded px-1.5 py-0.5 whitespace-nowrap">{{ $expDate }}</span>
                                            @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-300">&mdash;</span>
                                        @endif
                                    </td>
                                    @if($vIdx === 0)
                                        <td class="px-4 py-3 align-top" rowspan="{{ $rowCount }}">{{ $item->unit }}</td>
                                        <td class="px-4 py-3 text-right font-semibold align-top {{ $item->quantity <= 10 ? 'text-red-600' : 'text-green-600' }}" rowspan="{{ $rowCount }}">
                                            {{ number_format($item->quantity, 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-500 align-top" rowspan="{{ $rowCount }}">{{ $item->creator->name }}</td>
                                        <td class="px-4 py-3 align-top" rowspan="{{ $rowCount }}">
                                            <div class="flex flex-wrap gap-2 items-start">
                                                <a href="{{ route('items.show', $item) }}" class="text-blue-600 hover:underline">View</a>
                                                @if(Auth::user()->canAccess('items.manage'))
                                                <a href="{{ route('items.edit', $item) }}" class="text-yellow-600 hover:underline">Edit</a>
                                                <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('Delete this item?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                                <form method="POST" action="{{ route('items.archive', $item) }}" onsubmit="return confirm('Archive [{{ $item->code }}]? It will be hidden from active lists.')">
                                                    @csrf
                                                    <button class="text-gray-500 hover:underline">Archive</button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            @empty
                            <tr><td colspan="{{ Auth::user()->canAccess('items.manage') ? 10 : 9 }}" class="px-4 py-6 text-center text-gray-400">No items found. <a href="{{ route('items.create') }}" class="text-indigo-600 hover:underline">Add first item</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    </form>
                    <div class="mt-4">{{ $items->links() }}</div>

                    <script>
                    const checkAll  = document.getElementById('check-all');
                    const btnDelete = document.getElementById('btn-delete-selected');
                    const countSpan = document.getElementById('selected-count');

                    function updateDeleteBtn() {
                        const checked = document.querySelectorAll('.row-check:checked').length;
                        countSpan.textContent = checked;
                        btnDelete.classList.toggle('hidden', checked === 0);
                    }

                    checkAll.addEventListener('change', function() {
                        document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
                        updateDeleteBtn();
                    });

                    document.querySelectorAll('.row-check').forEach(cb => {
                        cb.addEventListener('change', function() {
                            const all   = document.querySelectorAll('.row-check');
                            checkAll.checked = [...all].every(c => c.checked);
                            checkAll.indeterminate = !checkAll.checked && [...all].some(c => c.checked);
                            updateDeleteBtn();
                        });
                    });

                    function confirmBulkDelete() {
                        const n = document.querySelectorAll('.row-check:checked').length;
                        if (n === 0) return;
                        if (confirm('Delete ' + n + ' selected item(s)? This cannot be undone.')) {
                            document.getElementById('bulk-delete-form').submit();
                        }
                    }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
