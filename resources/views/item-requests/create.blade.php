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

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vendor / Supplier</label>
                            <select name="vendor_name" id="vendor_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Item first --</option>
                            </select>
                            @error('vendor_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <select name="expiry_date" id="expiry_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select Vendor first --</option>
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
    const oldVendor  = "{{ old('vendor_name') }}";
    const oldExpiry  = "{{ old('expiry_date') }}";

    function formatDate(ymd) {
        if (!ymd) return ymd;
        const [y, m, d] = ymd.split('-');
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return d + ' ' + months[parseInt(m)-1] + ' ' + y;
    }

    function updateVendors(itemId) {
        const vendorSel  = document.getElementById('vendor_name');
        const expirySel  = document.getElementById('expiry_date');
        const vendors    = itemId ? (itemVendorData[itemId] ?? {}) : {};
        const vendorList = Object.keys(vendors);

        vendorSel.innerHTML  = '';
        expirySel.innerHTML  = '<option value="">-- Select Vendor first --</option>';

        if (vendorList.length === 0) {
            vendorSel.innerHTML = '<option value="">-- No vendor data --</option>';
            return;
        }

        const placeholder = new Option('-- Select Vendor --', '');
        vendorSel.appendChild(placeholder);
        vendorList.forEach(function(name) {
            const opt = new Option(name, name);
            if (name === oldVendor) opt.selected = true;
            vendorSel.appendChild(opt);
        });

        if (oldVendor && vendors[oldVendor]) {
            updateExpiry(itemId, oldVendor);
        }
    }

    function updateExpiry(itemId, vendorName) {
        const expirySel = document.getElementById('expiry_date');
        const dates     = (itemVendorData[itemId] ?? {})[vendorName] ?? [];

        expirySel.innerHTML = '';

        const placeholder = new Option(dates.length ? '-- Select Expiry Date --' : '-- No expiry recorded --', '');
        expirySel.appendChild(placeholder);

        dates.forEach(function(d) {
            const opt = new Option(formatDate(d), d);
            if (d === oldExpiry) opt.selected = true;
            expirySel.appendChild(opt);
        });
    }

    document.getElementById('item_id').addEventListener('change', function() {
        updateVendors(this.value);
    });

    document.getElementById('vendor_name').addEventListener('change', function() {
        const itemId = document.getElementById('item_id').value;
        updateExpiry(itemId, this.value);
    });

    // Restore on validation error
    const initItem = document.getElementById('item_id').value;
    if (initItem) updateVendors(initItem);
    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
