<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Item</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('items.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item Code *</label>
                            <input type="text" name="code" value="{{ old('code') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. ITM-001">
                            @error('code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Item Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. A4 Paper">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit *</label>
                            <input type="text" name="unit" value="{{ old('unit', 'pcs') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="e.g. pcs, box, kg, liter">
                            @error('unit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Suppliers</label>
                            <div id="supplier-list" class="space-y-2">
                                <div class="flex gap-2 supplier-row">
                                    <input type="text" name="suppliers[]"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                        placeholder="e.g. PT. Supplier Jaya">
                                    <button type="button" onclick="removeSupplier(this)"
                                        class="text-red-400 hover:text-red-600 px-2 text-lg leading-none">&times;</button>
                                </div>
                            </div>
                            <button type="button" onclick="addSupplier()"
                                class="mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium">+ Add another supplier</button>
                            @error('suppliers.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Optional description">{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Save Item</button>
                            <a href="{{ route('items.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function addSupplier(value) {
        const list = document.getElementById('supplier-list');
        const div  = document.createElement('div');
        div.className = 'flex gap-2 supplier-row';
        div.innerHTML = `<input type="text" name="suppliers[]"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
            placeholder="e.g. PT. Supplier Jaya" value="${value ?? ''}">
            <button type="button" onclick="removeSupplier(this)"
                class="text-red-400 hover:text-red-600 px-2 text-lg leading-none">&times;</button>`;
        list.appendChild(div);
    }
    function removeSupplier(btn) {
        const rows = document.querySelectorAll('.supplier-row');
        if (rows.length > 1) btn.closest('.supplier-row').remove();
        else btn.closest('.supplier-row').querySelector('input').value = '';
    }
    </script>
</x-app-layout>
