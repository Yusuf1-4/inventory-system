<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Receive Stock from Supplier</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('stock-receipts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item *</label>
                            <select name="item_id" id="item_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Item --</option>
                                @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ (old('item_id', request('item_id')) == $item->id) ? 'selected' : '' }}>
                                    [{{ $item->code }}] {{ $item->name }} (Stock: {{ $item->quantity }} {{ $item->unit }})
                                </option>
                                @endforeach
                            </select>
                            @error('item_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. of Units / Bags *</label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}" step="1" min="1" max="10000"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. 1000">
                            <p class="text-xs text-gray-400 mt-1">Each unit will get its own auto-generated batch number.</p>
                            @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name *</label>
                            <select name="supplier_name" id="supplier_name"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Item first --</option>
                            </select>
                            @error('supplier_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">GRN No. *</label>
                            <input type="text" name="grn_number" value="{{ old('grn_number') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. 00123">
                            <p class="text-xs text-gray-400 mt-1">The official document number for this Goods Received Note.</p>
                            @error('grn_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lot No (from Supplier) *</label>
                            <input type="text" name="lot_number" value="{{ old('lot_number') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. LOT-2026-001">
                            <p class="text-xs text-gray-400 mt-1">The lot reference number provided by the supplier for this delivery.</p>
                            @error('lot_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('expiry_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Received Date *</label>
                            <input type="date" name="received_date" value="{{ old('received_date', date('Y-m-d')) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('received_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Document Uploads -->
                        <div class="border-t border-gray-200 my-6 pt-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Supporting Documents (PDF, Docx, or Images)</h3>

                            <!-- Good Received Note (GRN) -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Goods Received Note (GRN)</label>
                                <input type="file" name="grn_file"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('grn_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Delivery Order (DO) -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Order (DO) *</label>
                                <input type="file" name="do_file"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('do_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Certificate of Analysis (COA) -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Certificate of Analysis (COA)</label>
                                <input type="file" name="coa_file"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('coa_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Optional notes e.g. invoice number, PO number">{{ old('notes') }}</textarea>
                            @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Save Receipt</button>
                            <a href="{{ route('stock-receipts.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    const itemSuppliers = @json($itemSuppliers);
    const oldSupplier   = "{{ old('supplier_name') }}";

    function updateSuppliers(itemId) {
        const select  = document.getElementById('supplier_name');
        const suppliers = itemId ? (itemSuppliers[itemId] ?? []) : [];

        select.innerHTML = '';

        if (suppliers.length === 0) {
            select.innerHTML = '<option value="">-- No suppliers found --</option>';
            return;
        }

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Select Supplier --';
        select.appendChild(placeholder);

        suppliers.forEach(function(name) {
            const opt = document.createElement('option');
            opt.value = name;
            opt.textContent = name;
            if (name === oldSupplier) opt.selected = true;
            select.appendChild(opt);
        });
    }

    document.getElementById('item_id').addEventListener('change', function() {
        updateSuppliers(this.value);
    });

    // Restore state on page load (e.g. after validation error)
    const initialItem = document.getElementById('item_id').value;
    if (initialItem) updateSuppliers(initialItem);
    </script>
</x-app-layout>
