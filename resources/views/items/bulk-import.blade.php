<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bulk Import Items</h2>
            <a href="{{ route('items.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Item Master</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Instructions --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 text-sm text-blue-800">
                <p class="font-semibold mb-2">How to use:</p>
                <ol class="list-decimal list-inside space-y-1">
                    <li>Open your Excel / Google Sheets spreadsheet.</li>
                    <li>Arrange columns in this order: <strong>Code &nbsp;|&nbsp; Name &nbsp;|&nbsp; Unit &nbsp;|&nbsp; Suppliers &nbsp;|&nbsp; Description</strong></li>
                    <li>For <strong>multiple suppliers</strong> in one cell, separate them with a semicolon: <code class="bg-blue-100 px-1 rounded">Supplier A; Supplier B</code></li>
                    <li>Select the data rows (no header row needed) and copy (<kbd class="bg-blue-100 px-1 rounded">Ctrl+C</kbd>).</li>
                    <li>Click the textarea below and paste (<kbd class="bg-blue-100 px-1 rounded">Ctrl+V</kbd>).</li>
                    <li>A preview table will appear — check the data then click <strong>Import Items</strong>.</li>
                </ol>
                <p class="mt-2 text-blue-600">Unit defaults to <strong>pcs</strong> if left blank. Rows with a duplicate code will be skipped.</p>
            </div>

            {{-- Column reference --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Column Order Reference</p>
                <div class="overflow-x-auto">
                    <table class="text-sm border border-gray-200 rounded w-full">
                        <thead class="bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-left border-r border-gray-200">A — Code *</th>
                                <th class="px-4 py-2 text-left border-r border-gray-200">B — Name *</th>
                                <th class="px-4 py-2 text-left border-r border-gray-200">C — Unit</th>
                                <th class="px-4 py-2 text-left border-r border-gray-200">D — Suppliers (semicolon-separated)</th>
                                <th class="px-4 py-2 text-left">E — Description</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-500">
                            <tr class="bg-gray-50 italic">
                                <td class="px-4 py-2 border-r border-gray-200">ITM-001</td>
                                <td class="px-4 py-2 border-r border-gray-200">A4 Paper</td>
                                <td class="px-4 py-2 border-r border-gray-200">ream</td>
                                <td class="px-4 py-2 border-r border-gray-200">PT. Jaya; PT. Maju</td>
                                <td class="px-4 py-2">80gsm white</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paste Form --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('items.bulk-import.store') }}" id="bulkForm">
                    @csrf

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Paste spreadsheet data here
                    </label>
                    <textarea id="pasteArea" name="rows" rows="8"
                        class="w-full font-mono text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Paste your copied rows from Excel or Google Sheets here...">{{ old('rows') }}</textarea>
                    @error('rows')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                    {{-- Update existing toggle --}}
                    <div class="mt-4 flex items-start gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <input type="checkbox" name="update_existing" id="update_existing" value="1"
                            class="mt-0.5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ old('update_existing') ? 'checked' : '' }}>
                        <label for="update_existing" class="text-sm text-yellow-800 cursor-pointer">
                            <span class="font-semibold">Update existing items if code matches</span><br>
                            <span class="text-yellow-700">If a code already exists in the system, overwrite its name, unit, supplier and description with the pasted values. Stock quantity is never changed.</span>
                        </label>
                    </div>
                    <div id="previewWrap" class="hidden mt-6">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Preview (<span id="rowCount">0</span> rows)</p>
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                    <tr>
                                        <th class="px-3 py-2 text-left">#</th>
                                        <th class="px-3 py-2 text-left">Code</th>
                                        <th class="px-3 py-2 text-left">Name</th>
                                        <th class="px-3 py-2 text-left">Unit</th>
                                        <th class="px-3 py-2 text-left">Suppliers</th>
                                        <th class="px-3 py-2 text-left">Description</th>
                                        <th class="px-3 py-2 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="previewBody" class="divide-y divide-gray-100"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit" id="submitBtn"
                            class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 disabled:opacity-40 disabled:cursor-not-allowed"
                            disabled>
                            Import Items
                        </button>
                        <a href="{{ route('items.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded hover:bg-gray-200">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
    (function () {
        const ta      = document.getElementById('pasteArea');
        const wrap    = document.getElementById('previewWrap');
        const body    = document.getElementById('previewBody');
        const counter = document.getElementById('rowCount');
        const btn     = document.getElementById('submitBtn');
        const updateChk = document.getElementById('update_existing');

        // Codes already in DB passed from server (for JS preview hint)
        const existingCodes = @json(\App\Models\Item::pluck('code')->toArray());

        function parseRows(text) {
            return text.split(/\r\n|\r|\n/)
                .map(l => l.trim())
                .filter(l => l !== '')
                .map(line => line.includes('\t')
                    ? line.split('\t').map(c => c.trim())
                    : line.split(',').map(c => c.trim().replace(/^"|"$/g, ''))
                );
        }

        function escape(s) {
            return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        }

        function render(text) {
            const rows = parseRows(text);
            const willUpdate = updateChk && updateChk.checked;

            if (rows.length === 0) {
                wrap.classList.add('hidden');
                btn.disabled = true;
                return;
            }

            let html = '';
            rows.forEach((cols, i) => {
                const code = cols[0] ?? '';
                const name = cols[1] ?? '';
                const unit = cols[2] || 'pcs';
                const supp = cols[3] ?? '';
                const desc = cols[4] ?? '';

                const isDuplicate = existingCodes.includes(code);
                let statusBadge;

                if (!code || !name) {
                    statusBadge = '<span class="inline-block px-2 py-0.5 bg-red-100 text-red-600 rounded text-xs font-medium">&#x26A0; Missing code/name</span>';
                } else if (isDuplicate && willUpdate) {
                    statusBadge = '<span class="inline-block px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">&#x21BB; Will update</span>';
                } else if (isDuplicate) {
                    statusBadge = '<span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-500 rounded text-xs font-medium">&#8212; Will skip</span>';
                } else {
                    statusBadge = '<span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-medium">&#10003; New</span>';
                }

                const rowClass = isDuplicate && !willUpdate ? 'opacity-40' : 'hover:bg-gray-50';

                html += `<tr class="${rowClass}">
                    <td class="px-3 py-2 text-gray-400">${i + 1}</td>
                    <td class="px-3 py-2 font-mono">${escape(code)}</td>
                    <td class="px-3 py-2 font-medium">${escape(name)}</td>
                    <td class="px-3 py-2">${escape(unit)}</td>
                    <td class="px-3 py-2 text-gray-500">${escape(supp)}</td>
                    <td class="px-3 py-2 text-gray-500">${escape(desc)}</td>
                    <td class="px-3 py-2">${statusBadge}</td>
                </tr>`;
            });

            body.innerHTML = html;
            counter.textContent = rows.length;
            wrap.classList.remove('hidden');
            btn.disabled = rows.length === 0;
        }

        ta.addEventListener('input', () => render(ta.value));
        ta.addEventListener('paste', () => setTimeout(() => render(ta.value), 50));
        updateChk.addEventListener('change', () => render(ta.value));

        // Restore on page reload with old() value
        if (ta.value.trim()) render(ta.value);
    })();
    </script>
</x-app-layout>
