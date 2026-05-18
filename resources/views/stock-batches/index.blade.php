<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Batches</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filters --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-5 mb-6">
                <form method="GET" action="{{ route('stock-batches.index') }}" class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Item</label>
                        <select name="item_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Items</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                [{{ $item->code }}] {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="min-w-[150px]">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Lot No</label>
                        <input type="text" name="lot_number" value="{{ request('lot_number') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Search lot…">
                    </div>
                    <div class="min-w-[180px]">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Batch No</label>
                        <input type="text" name="batch_number" value="{{ request('batch_number') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Search batch…">
                    </div>
                    <div class="min-w-[130px]">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Status</option>
                            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="issued"    {{ request('status') === 'issued'    ? 'selected' : '' }}>Issued</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">Search</button>
                        @if(request()->hasAny(['item_id','lot_number','batch_number','status']))
                        <a href="{{ route('stock-batches.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 text-sm">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Summary cards --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-gray-800">{{ number_format($totalCount) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Total Batches</div>
                </div>
                <div class="bg-green-50 shadow-sm rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-green-700">{{ number_format($availableCount) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Available</div>
                </div>
                <div class="bg-red-50 shadow-sm rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-red-600">{{ number_format($issuedCount) }}</div>
                    <div class="text-xs text-gray-500 mt-1">Issued</div>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($batches->isEmpty())
                    <p class="text-center text-gray-400 py-8">No batches found.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Batch Number</th>
                                    <th class="px-4 py-3">Lot No</th>
                                    <th class="px-4 py-3">Item</th>
                                    <th class="px-4 py-3">Expiry Date</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">Tunnel</th>
                                    <th class="px-4 py-3 text-center">QR Code</th>
                                    <th class="px-4 py-3 text-center">Print</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($batches as $batch)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-400 text-xs">
                                        {{ ($batches->currentPage() - 1) * $batches->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="font-mono font-semibold text-gray-800">{{ $batch->batch_number }}</span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('stock-receipts.batches', $batch->stock_receipt_id) }}"
                                            class="font-mono text-xs text-indigo-700 hover:underline">
                                            {{ $batch->lot_number }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="font-medium text-gray-800">{{ $batch->item->name }}</div>
                                        <div class="text-xs text-gray-400 font-mono">{{ $batch->item->code }}</div>
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($batch->expiry_date)
                                            @php $dl = now()->startOfDay()->diffInDays($batch->expiry_date, false); @endphp
                                            <span class="{{ $dl < 0 ? 'text-red-600 font-semibold' : ($dl <= 90 ? 'text-orange-500' : 'text-gray-700') }}">
                                                {{ $batch->expiry_date->format('d M Y') }}
                                                @if($dl < 0)<span class="text-xs"> (Exp)</span>
                                                @elseif($dl <= 90)<span class="text-xs"> ({{ $dl }}d)</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($batch->status === 'available')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-700">Available</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-600">Issued</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <button type="button"
                                                id="tbn-{{ $batch->id }}"
                                                data-batch="{{ $batch->id }}"
                                                data-tunnel="{{ $batch->tunnel ?? '' }}"
                                                onclick="openTunnelMap(this)"
                                                title="Click to assign warehouse location"
                                                class="inline-flex items-center justify-center px-2.5 py-1 rounded text-xs font-bold font-mono tracking-wide transition min-w-[2.5rem] {{ $batch->tunnel ? 'bg-indigo-100 text-indigo-700 border border-indigo-200 hover:bg-indigo-200' : 'bg-gray-100 text-gray-400 border border-dashed border-gray-300 hover:bg-gray-200' }}">
                                            {!! $batch->tunnel ?: '&mdash;' !!}
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        {!! QrCode::size(72)->margin(1)->generate($batch->batch_number) !!}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="{{ route('stock-batches.label', $batch) }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-xs bg-indigo-50 text-indigo-700 border border-indigo-200 px-3 py-1.5 rounded hover:bg-indigo-100">
                                            &#128438; Print
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-xs text-gray-500">
                            Showing {{ $batches->firstItem() }}–{{ $batches->lastItem() }} of {{ number_format($batches->total()) }} batches
                        </p>
                        <div>{{ $batches->links() }}</div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>


<style>
.wm-grid { display:flex; flex-direction:column; gap:2px; }
.wm-row  { display:flex; gap:2px; }
.wm-cell {
    width:32px; height:26px;
    border:1.5px solid #d1d5db; border-radius:3px;
    display:flex; align-items:center; justify-content:center;
    font-size:9.5px; font-weight:700; color:#374151;
    background:#f9fafb; cursor:pointer; user-select:none;
    letter-spacing:-0.02em; flex-shrink:0;
    transition:background .1s, border-color .1s;
}
.wm-cell:hover  { background:#e0e7ff; border-color:#818cf8; color:#4338ca; }
.wm-cell-active { background:#4f46e5 !important; border-color:#4338ca !important;
                  color:#fff !important; box-shadow:0 0 0 2px rgba(79,70,229,.3); }
</style>

{{-- Warehouse Map Modal (plain HTML — no Alpine) --}}
<div id="tunnel-modal" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40" onclick="TM.close()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl z-10 p-6" style="width:580px;max-width:100%">

        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800 text-base">Assign Warehouse Location</h3>
            <button onclick="TM.close()" class="text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
        </div>

        <div class="wm-grid" id="wm-grid">
            {{-- Row P: P1–P8 --}}
            <div class="wm-row">
                @foreach(range(1,8) as $n)
                <div class="wm-cell" data-pos="P{{ $n }}" onclick="TM.assign('P{{ $n }}')">P{{ $n }}</div>
                @endforeach
            </div>
            {{-- Row N: N1–N9 --}}
            <div class="wm-row">
                @foreach(range(1,9) as $n)
                <div class="wm-cell" data-pos="N{{ $n }}" onclick="TM.assign('N{{ $n }}')">N{{ $n }}</div>
                @endforeach
            </div>
            {{-- Row M: M1–M15 --}}
            <div class="wm-row">
                @foreach(range(1,15) as $n)
                <div class="wm-cell" data-pos="M{{ $n }}" onclick="TM.assign('M{{ $n }}')">M{{ $n }}</div>
                @endforeach
            </div>
            <div style="height:8px"></div>
            {{-- Row R/L: R2, R1, L1–L9 (indent 4×34px=136px) --}}
            <div class="wm-row" style="margin-left:136px">
                <div class="wm-cell" data-pos="R2" onclick="TM.assign('R2')">R2</div>
                <div class="wm-cell" data-pos="R1" onclick="TM.assign('R1')">R1</div>
                @foreach(range(1,9) as $n)
                <div class="wm-cell" data-pos="L{{ $n }}" onclick="TM.assign('L{{ $n }}')">L{{ $n }}</div>
                @endforeach
            </div>
            {{-- Row S/K: S2, S1, K1–K9 --}}
            <div class="wm-row" style="margin-left:136px">
                <div class="wm-cell" data-pos="S2" onclick="TM.assign('S2')">S2</div>
                <div class="wm-cell" data-pos="S1" onclick="TM.assign('S1')">S1</div>
                @foreach(range(1,9) as $n)
                <div class="wm-cell" data-pos="K{{ $n }}" onclick="TM.assign('K{{ $n }}')">K{{ $n }}</div>
                @endforeach
            </div>
            <div style="height:8px"></div>
            {{-- Row T: T1–T6 (indent 9×34px=306px) --}}
            <div class="wm-row" style="margin-left:306px">
                @foreach(range(1,6) as $n)
                <div class="wm-cell" data-pos="T{{ $n }}" onclick="TM.assign('T{{ $n }}')">T{{ $n }}</div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
            <div id="wm-footer" class="text-sm"></div>
            <div class="flex items-center gap-3">
                <span id="wm-saving" style="display:none" class="text-xs text-indigo-500">Saving…</span>
                <button onclick="TM.close()" class="px-4 py-1.5 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
const TM = {
    batchId: null,
    tunnel:  null,

    open(btn) {
        this.batchId = btn.dataset.batch;
        this.tunnel  = btn.dataset.tunnel || null;
        this._syncCells();
        this._syncFooter();
        document.getElementById('tunnel-modal').style.display = 'flex';
    },

    close() {
        document.getElementById('tunnel-modal').style.display = 'none';
    },

    assign(pos) {
        const newTunnel = (!pos || this.tunnel === pos) ? null : pos;
        this._setSaving(true);

        const csrfEl = document.querySelector('meta[name="csrf-token"]');
        if (!csrfEl) {
            this._setSaving(false);
            alert('Page error: CSRF token missing. Please refresh and try again.');
            return;
        }

        fetch('/stock-batches/' + this.batchId + '/tunnel', {
            method:  'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfEl.getAttribute('content'),
                'Accept':       'application/json',
            },
            body: JSON.stringify({ tunnel: newTunnel }),
        })
        .then(function(r) {
            if (!r.ok) return r.text().then(function(t) { throw new Error('HTTP ' + r.status + ': ' + t); });
            return r.json();
        })
        .then(function(data) {
            TM.tunnel = data.tunnel;
            TM._syncCells();
            TM._syncFooter();
            TM._setSaving(false);
            // Refresh the badge button in the table row
            var btn = document.getElementById('tbn-' + TM.batchId);
            if (btn) {
                btn.innerHTML      = data.tunnel ? data.tunnel : '&mdash;';
                btn.dataset.tunnel = data.tunnel || '';
                var has = !!data.tunnel;
                btn.className = 'inline-flex items-center justify-center px-2.5 py-1 rounded text-xs font-bold font-mono tracking-wide transition min-w-[2.5rem] '
                    + (has ? 'bg-indigo-100 text-indigo-700 border border-indigo-200 hover:bg-indigo-200'
                           : 'bg-gray-100 text-gray-400 border border-dashed border-gray-300 hover:bg-gray-200');
            }
            if (data.tunnel) TM.close();
        })
        .catch(function(err) {
            TM._setSaving(false);
            alert('Could not save tunnel assignment.\n' + err.message);
        });
    },

    remove() { this.assign(this.tunnel); },

    _syncCells() {
        document.querySelectorAll('#wm-grid .wm-cell').forEach(c => {
            c.classList.toggle('wm-cell-active', c.dataset.pos === this.tunnel);
        });
    },

    _syncFooter() {
        const el = document.getElementById('wm-footer');
        el.innerHTML = this.tunnel
            ? 'Assigned: <strong class="text-indigo-600 font-mono">' + this.tunnel + '</strong>'
              + ' <button onclick="TM.remove()" class="ml-2 text-xs text-red-400 hover:text-red-600 underline">Remove</button>'
            : '<span class="text-gray-400 text-xs">No location assigned — click a cell</span>';
    },

    _setSaving(v) {
        document.getElementById('wm-saving').style.display = v ? 'inline' : 'none';
        const g = document.getElementById('wm-grid');
        g.style.pointerEvents = v ? 'none' : '';
        g.style.opacity       = v ? '0.5'  : '';
    },
};

function openTunnelMap(btn) { TM.open(btn); }
</script>

</x-app-layout>
