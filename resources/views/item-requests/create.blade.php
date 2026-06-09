<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Stock Issue</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if($errors->any())
                    <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('item-requests.store') }}">
                        @csrf

                        {{-- 1. Item Dropdown --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item *</label>
                            <select name="item_id" id="item_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Item --</option>
                                @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    [{{ $item->code }}] {{ $item->name }} (Available: {{ $item->quantity }} {{ $item->unit }})
                                </option>
                                @endforeach
                            </select>
                            @error('item_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- 2. Vendor Dropdown --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor / Supplier</label>
                            <select name="vendor_name" id="vendor_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Item first --</option>
                            </select>
                            @error('vendor_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- 3. Lot Number Dropdown --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lot No. *</label>
                            <select name="lot_number" id="lot_number" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Vendor first --</option>
                            </select>
                            @error('lot_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- 4. Batch Number Dropdown (NEW) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Batch No. *</label>
                            <select name="batch_number" id="batch_number" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Lot No first --</option>
                            </select>
                            @error('batch_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- 5. Expiry Date Dropdown --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <select name="expiry_date" id="expiry_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Batch No first --</option>
                            </select>
                            @error('expiry_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity Needed *</label>
                            <input type="number" name="quantity_requested" value="{{ old('quantity_requested') }}" step="0.01" min="0.01"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. 5">
                            @error('quantity_requested')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Purpose / Reason *</label>
                            <input type="text" name="purpose" value="{{ old('purpose') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. For printing project proposal">
                            @error('purpose')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                            <textarea name="notes" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Any additional information">{{ old('notes') }}</textarea>
                            @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Submit Issue</button>
                            <a href="{{ route('item-requests.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">Cancel</a>
                        </div>
                    </form>

    <script>
    const itemVendorData = @json($itemVendorData);
    const oldVendor      = "{{ old('vendor_name') }}";
    const oldLot         = "{{ old('lot_number') }}";
    const oldBatch       = "{{ old('batch_number') }}";
    const oldExpiry      = "{{ old('expiry_date') }}";

    function formatDate(ymd) {
        if (!ymd) return ymd;
        const [y, m, d] = ymd.split('-');
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return d + ' ' + months[parseInt(m)-1] + ' ' + y;
    }

    function updateVendors(itemId) {
        const vendorSel = document.getElementById('vendor_name');
        const lotSel    = document.getElementById('lot_number');
        const batchSel  = document.getElementById('batch_number');
        const expirySel = document.getElementById('expiry_date');

        const vendors    = itemId ? (itemVendorData[itemId] ?? {}) : {};
        const vendorList = Object.keys(vendors);

        vendorSel.innerHTML = '';
        lotSel.innerHTML    = '<option value="">-- Select Vendor first --</option>';
        batchSel.innerHTML  = '<option value="">-- Select Lot No first --</option>';
        expirySel.innerHTML = '<option value="">-- Select Batch No first --</option>';

        if (vendorList.length === 0) {
            vendorSel.innerHTML = '<option value="">-- No vendor data --</option>';
            return;
        }

        vendorSel.appendChild(new Option('-- Select Vendor --', ''));
        vendorList.forEach(function(name) {
            const opt = new Option(name, name);
            if (name === oldVendor) opt.selected = true;
            vendorSel.appendChild(opt);
        });

        if (oldVendor && vendors[oldVendor]) {
            updateLots(itemId, oldVendor);
        }
    }

    function updateLots(itemId, vendorName) {
        const lotSel    = document.getElementById('lot_number');
        const batchSel  = document.getElementById('batch_number');
        const expirySel = document.getElementById('expiry_date');

        const lots    = (itemId && vendorName) ? ((itemVendorData[itemId] ?? {})[vendorName] ?? {}) : {};
        const lotList = Object.keys(lots);

        lotSel.innerHTML    = '';
        batchSel.innerHTML  = '<option value="">-- Select Lot No first --</option>';
        expirySel.innerHTML = '<option value="">-- Select Batch No first --</option>';

        if (lotList.length === 0) {
            lotSel.innerHTML = '<option value="">-- No lot data --</option>';
            return;
        }

        lotSel.appendChild(new Option('-- Select Lot No --', ''));
        lotList.forEach(function(lot) {
            const opt = new Option(lot, lot);
            if (lot === oldLot) opt.selected = true;
            lotSel.appendChild(opt);
        });

        if (oldLot && lots[oldLot]) {
            updateBatches(itemId, vendorName, oldLot);
        }
    }

    function updateBatches(itemId, vendorName, lotNo) {
        const batchSel  = document.getElementById('batch_number');
        const expirySel = document.getElementById('expiry_date');

        const batches    = (itemId && vendorName && lotNo) ? (((itemVendorData[itemId] ?? {})[vendorName] ?? {})[lotNo] ?? {}) : {};
        const batchList  = Object.keys(batches);

        batchSel.innerHTML  = '';
        expirySel.innerHTML = '<option value="">-- Select Batch No first --</option>';

        if (batchList.length === 0) {
            batchSel.innerHTML = '<option value="">-- No batch data --</option>';
            return;
        }

        batchSel.appendChild(new Option('-- Select Batch No --', ''));
        batchList.forEach(function(batch) {
            const opt = new Option(batch, batch);
            if (batch === oldBatch) opt.selected = true;
            batchSel.appendChild(opt);
        });

        if (oldBatch && batches[oldBatch]) {
            updateExpiry(itemId, vendorName, lotNo, oldBatch);
        }
    }

    function updateExpiry(itemId, vendorName, lotNo, batchNo) {
        const expirySel = document.getElementById('expiry_date');

        // Drill down 4 levels to get the specific expiry date for this batch
        const expiryDate = (itemId && vendorName && lotNo && batchNo)
            ? ((((itemVendorData[itemId] ?? {})[vendorName] ?? {})[lotNo] ?? {})[batchNo])
            : null;

        expirySel.innerHTML = '';

        if (!expiryDate) {
            expirySel.innerHTML = '<option value="">-- No expiry recorded --</option>';
            return;
        }

        const opt = new Option(formatDate(expiryDate), expiryDate);
        opt.selected = true;
        expirySel.appendChild(opt);
    }

    // Event Listeners
    document.getElementById('item_id').addEventListener('change', function() {
        updateVendors(this.value);
    });

    document.getElementById('vendor_name').addEventListener('change', function() {
        const itemId = document.getElementById('item_id').value;
        updateLots(itemId, this.value);
    });

    document.getElementById('lot_number').addEventListener('change', function() {
        const itemId = document.getElementById('item_id').value;
        const vendorName = document.getElementById('vendor_name').value;
        updateBatches(itemId, vendorName, this.value);
    });

    document.getElementById('batch_number').addEventListener('change', function() {
        const itemId = document.getElementById('item_id').value;
        const vendorName = document.getElementById('vendor_name').value;
        const lotNo = document.getElementById('lot_number').value;
        updateExpiry(itemId, vendorName, lotNo, this.value);
    });

    // Restore UI state on validation error redirects
    const initItem = document.getElementById('item_id').value;
    if (initItem) updateVendors(initItem);
    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
