<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Return Stock from Production</h2>
            <a href="{{ route('stock-receipts.index', ['type' => 'production']) }}" class="text-sm text-gray-500 hover:underline">&larr; Back to Production Returns</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Info banner --}}
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg p-4 text-sm">
                <strong>Production Return</strong> — Use this form when leftover materials from a production run
                are sent back to inventory. Select the original approved request, then enter how many units are being returned.
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 rounded p-3 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    @if($approvedRequests->isEmpty())
                    <div class="text-center py-10 text-gray-400">
                        <p>No approved requests found.</p>
                        <p class="text-xs mt-1">Only approved item requests can have a production return.</p>
                    </div>
                    @else
                    <form method="POST" action="{{ route('stock-receipts.return.store') }}">
                        @csrf

                        {{-- Approved Request selector --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Approved Request *</label>
                            <select name="item_request_id" id="item_request_id"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Approved Request --</option>
                                @foreach($approvedRequests as $req)
                                <option value="{{ $req->id }}"
                                    data-item="{{ $req->item->name }}"
                                    data-code="{{ $req->item->code }}"
                                    data-unit="{{ $req->item->unit }}"
                                    data-qty="{{ $req->quantity_requested }}"
                                    {{ old('item_request_id') == $req->id ? 'selected' : '' }}>
                                    #{{ $req->id }} — [{{ $req->item->code }}] {{ $req->item->name }}
                                    (Approved qty: {{ $req->quantity_requested }} {{ $req->item->unit }})
                                    @if($req->purpose) — {{ Str::limit($req->purpose, 40) }}@endif
                                </option>
                                @endforeach
                            </select>
                            @error('item_request_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Item info card (shown after selecting request) --}}
                        <div id="item_info" class="mb-4 hidden bg-gray-50 border border-gray-200 rounded p-3 text-sm text-gray-700">
                            <span class="font-medium">Item:</span>
                            <span id="info_name"></span>
                            <span class="text-gray-400 ml-1" id="info_code"></span>
                            <span class="ml-4 font-medium">Approved Qty:</span>
                            <span id="info_qty" class="text-indigo-700 font-semibold"></span>
                            <span id="info_unit" class="ml-1 text-gray-500"></span>
                        </div>

                        {{-- Quantity to return --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity Returned *</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}"
                                step="0.01" min="0.01"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. 5">
                            <p id="qty_hint" class="text-xs text-gray-400 mt-1 hidden">Must not exceed the approved quantity.</p>
                            @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Return Date --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Return Date *</label>
                            <input type="date" name="received_date" value="{{ old('received_date', date('Y-m-d')) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('received_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Notes --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Optional — e.g. reason for leftover, production batch ref">{{ old('notes') }}</textarea>
                            @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Record Return</button>
                            <a href="{{ route('stock-receipts.index', ['type' => 'production']) }}"
                                class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">Cancel</a>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    const select = document.getElementById('item_request_id');

    function updateItemInfo() {
        const opt = select.options[select.selectedIndex];
        const info = document.getElementById('item_info');
        const qtyHint = document.getElementById('qty_hint');
        const qtyInput = document.getElementById('quantity');

        if (!opt || !opt.value) {
            info.classList.add('hidden');
            qtyHint.classList.add('hidden');
            qtyInput.removeAttribute('max');
            return;
        }

        document.getElementById('info_name').textContent = opt.dataset.item;
        document.getElementById('info_code').textContent = '[' + opt.dataset.code + ']';
        document.getElementById('info_qty').textContent  = opt.dataset.qty;
        document.getElementById('info_unit').textContent = opt.dataset.unit;

        qtyInput.setAttribute('max', opt.dataset.qty);
        qtyHint.textContent = 'Must not exceed ' + opt.dataset.qty + ' ' + opt.dataset.unit + '.';

        info.classList.remove('hidden');
        qtyHint.classList.remove('hidden');
    }

    select.addEventListener('change', updateItemInfo);

    // Restore on validation error
    if (select.value) updateItemInfo();
    </script>
</x-app-layout>
