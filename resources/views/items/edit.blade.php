<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Item: {{ $item->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('items.update', $item) }}">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item Code *</label>
                            <input type="text" name="code" value="{{ old('code', $item->code) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item Name *</label>
                            <input type="text" name="name" value="{{ old('name', $item->name) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit *</label>
                            <input type="text" name="unit" value="{{ old('unit', $item->unit) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('unit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Suppliers</label>
                            <div id="supplier-list" class="space-y-2">
                                @forelse($item->suppliers as $supplier)
                                <div class="flex gap-2 supplier-row">
                                    <input type="text" name="suppliers[]" value="{{ old('suppliers.' . $loop->index, $supplier->supplier_name) }}"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <button type="button" onclick="removeSupplier(this)"
                                        class="text-red-400 hover:text-red-600 px-2 text-lg leading-none">&times;</button>
                                </div>
                                @empty
                                <div class="flex gap-2 supplier-row">
                                    <input type="text" name="suppliers[]"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                        placeholder="e.g. PT. Supplier Jaya">
                                    <button type="button" onclick="removeSupplier(this)"
                                        class="text-red-400 hover:text-red-600 px-2 text-lg leading-none">&times;</button>
                                </div>
                                @endforelse
                            </div>
                            <button type="button" onclick="addSupplier()"
                                class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium">+ Add another supplier</button>
                            @error('suppliers.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Quantity</label>
                            <input type="text" value="{{ $item->quantity }} {{ $item->unit }}" disabled
                                class="w-full border-gray-200 bg-gray-50 rounded-md text-gray-500">
                            <p class="text-xs text-gray-400 mt-1">Quantity is managed via Stock Receipts and Item Requests.</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $item->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update Item</button>
                            <a href="{{ route('items.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function addSupplier() {
        const list = document.getElementById('supplier-list');
        const div  = document.createElement('div');
        div.className = 'flex gap-2 supplier-row';
        div.innerHTML = `<input type="text" name="suppliers[]"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
            placeholder="e.g. PT. Supplier Jaya">
            <button type="button" onclick="removeSupplier(this)"
                class="text-red-400 hover:text-red-600 px-2 text-lg leading-none">&times;</button>`;
        list.appendChild(div);
        list.lastElementChild.querySelector('input').focus();
    }
    function removeSupplier(btn) {
        const rows = document.querySelectorAll('.supplier-row');
        if (rows.length > 1) btn.closest('.supplier-row').remove();
        else btn.closest('.supplier-row').querySelector('input').value = '';
    }
    </script>
</x-app-layout>
