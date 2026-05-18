<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemSupplier;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['creator', 'suppliers', 'stockReceipts'])->active()->latest()->paginate(15);
        return view('items.index', compact('items'));
    }

    public function archivedIndex()
    {
        $items = Item::with(['creator', 'suppliers'])->archived()->latest('archived_at')->paginate(15);
        return view('items.archived', compact('items'));
    }

    public function archive(Item $item)
    {
        $item->update(['archived_at' => now()]);
        AuditLogger::log('archived', 'Item', $item->id, "Archived item [{$item->code}] {$item->name}");
        return redirect()->route('items.index')->with('success', "Item [{$item->code}] archived successfully.");
    }

    public function unarchive(Item $item)
    {
        $item->update(['archived_at' => null]);
        AuditLogger::log('unarchived', 'Item', $item->id, "Unarchived item [{$item->code}] {$item->name}");
        return redirect()->route('items.archived')->with('success', "Item [{$item->code}] restored to active.");
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:items,code',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit'        => 'required|string|max:50',
            'suppliers'   => 'nullable|array',
            'suppliers.*' => 'nullable|string|max:255',
        ]);

        $item = Item::create([
            'code'        => $validated['code'],
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'unit'        => $validated['unit'],
            'quantity'    => 0,
            'created_by'  => auth()->id(),
        ]);

        $this->syncSuppliers($item, $request->input('suppliers', []));

        AuditLogger::log('created', 'Item', $item->id, "Created item [{$item->code}] {$item->name}");

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show(Item $item)
    {
        $item->load(['suppliers', 'stockReceipts.receiver', 'itemRequests.requester']);
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $item->load('suppliers');
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $oldValues = $item->only(['code', 'name', 'description', 'unit']);

        $validated = $request->validate([
            'code'        => 'required|string|max:50|unique:items,code,' . $item->id,
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit'        => 'required|string|max:50',
            'suppliers'   => 'nullable|array',
            'suppliers.*' => 'nullable|string|max:255',
        ]);

        $item->update([
            'code'        => $validated['code'],
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'unit'        => $validated['unit'],
        ]);

        $this->syncSuppliers($item, $request->input('suppliers', []));

        AuditLogger::log('updated', 'Item', $item->id, "Updated item [{$item->code}] {$item->name}",
            $oldValues,
            Arr::only($validated, ['code', 'name', 'description', 'unit'])
        );

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $label = "[{$item->code}] {$item->name}";
        $itemId = $item->id;
        $item->delete();
        AuditLogger::log('deleted', 'Item', $itemId, "Deleted item {$label}");
        return redirect()->route('items.index')
            ->with('success', 'Item deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:items,id']);
        $codes = Item::whereIn('id', $request->ids)->pluck('code')->toArray();
        $count = Item::whereIn('id', $request->ids)->delete();
        AuditLogger::log('bulk_deleted', 'Item', null, "Bulk deleted {$count} item(s): " . implode(', ', $codes));
        return redirect()->route('items.index')
            ->with('success', $count . ' item(s) deleted successfully.');
    }

    // ---------------------------------------------------------------
    // Bulk Import
    // ---------------------------------------------------------------

    public function bulkImportForm()
    {
        return view('items.bulk-import');
    }

    public function bulkImportStore(Request $request)
    {
        $request->validate([
            'rows'            => 'required|string',
            'update_existing' => 'nullable|boolean',
        ]);

        $updateExisting = (bool) $request->input('update_existing', false);
        $lines    = preg_split('/\r\n|\r|\n/', trim($request->rows));
        $inserted = 0;
        $updated  = 0;
        $skipped  = [];

        foreach ($lines as $lineNum => $line) {
            $line = trim($line);
            if ($line === '') continue;

            $cols = strpos($line, "\t") !== false
                ? explode("\t", $line)
                : str_getcsv($line);

            $cols = array_map('trim', $cols);

            $code        = $cols[0] ?? '';
            $name        = $cols[1] ?? '';
            $unit        = $cols[2] ?? 'pcs';
            // Column D: semicolon-separated supplier names e.g. "Supplier A; Supplier B"
            $suppRaw     = $cols[3] ?? '';
            $description = $cols[4] ?? null;

            $supplierNames = array_filter(
                array_map('trim', explode(';', $suppRaw)),
                fn($s) => $s !== ''
            );

            if ($code === '' || $name === '') {
                $skipped[] = 'Row ' . ($lineNum + 1) . ': missing code or name.';
                continue;
            }

            $existing = Item::where('code', $code)->first();

            if ($existing) {
                if ($updateExisting) {
                    $existing->update([
                        'name'        => $name,
                        'unit'        => $unit ?: 'pcs',
                        'description' => $description ?: $existing->description,
                    ]);
                    if ($supplierNames) {
                        $this->syncSuppliers($existing, $supplierNames);
                    }
                    $updated++;
                } else {
                    $skipped[] = 'Row ' . ($lineNum + 1) . ': code "' . $code . '" already exists — skipped.';
                }
                continue;
            }

            $item = Item::create([
                'code'        => $code,
                'name'        => $name,
                'unit'        => $unit ?: 'pcs',
                'description' => $description ?: null,
                'quantity'    => 0,
                'created_by'  => auth()->id(),
            ]);

            $this->syncSuppliers($item, $supplierNames);
            $inserted++;
        }

        $parts = [];
        if ($inserted) $parts[] = $inserted . ' item(s) imported.';
        if ($updated)  $parts[] = $updated  . ' item(s) updated.';
        if ($skipped)  $parts[] = count($skipped) . ' skipped: ' . implode(' | ', $skipped);

        if ($inserted || $updated) {
            AuditLogger::log('bulk_imported', 'Item', null, "Bulk import: {$inserted} inserted, {$updated} updated");
        }

        return redirect()->route('items.index')
            ->with('success', implode(' ', $parts) ?: 'Nothing to import.');
    }

    // ---------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------

    private function syncSuppliers(Item $item, array $names): void
    {
        $names = array_values(array_unique(
            array_filter(array_map('trim', $names), fn($n) => $n !== '')
        ));

        $item->suppliers()->delete();

        foreach ($names as $name) {
            $item->suppliers()->create(['supplier_name' => $name]);
        }
    }
}
