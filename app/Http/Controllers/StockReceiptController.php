<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\ItemSupplier;
use App\Models\StockBatch;
use App\Models\StockReceipt;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StockReceiptController extends Controller
{
    public function index()
    {
        $type     = request('type', 'supplier');
        $receipts = StockReceipt::with(['item', 'receiver', 'itemRequest'])
            ->where('type', $type)
            ->latest()
            ->paginate(15);
        return view('stock-receipts.index', compact('receipts', 'type'));
    }

    public function create()
    {
        $items = Item::with('suppliers')->active()->orderBy('name')->get();

        // Build a map of item_id => [supplier_name, ...]
        $itemSuppliers = $items->mapWithKeys(function ($item) {
            return [$item->id => $item->suppliers->pluck('supplier_name')->filter()->values()];
        });

        return view('stock-receipts.create', compact('items', 'itemSuppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'       => 'required|exists:items,id',
            'quantity'      => 'required|integer|min:1|max:10000',
            'supplier_name' => 'required|string|max:255',
            'grn_number'    => 'required|string|max:100',
            'lot_number'    => 'required|string|max:100',
            'expiry_date'   => 'nullable|date',
            'received_date' => 'required|date',
            'notes'         => 'nullable|string',

            // File validation: limit types and size (e.g., max 5MB per file)
            'grn_file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:5120',
            'do_file'        => 'required|file|mimes:pdf,jpg,jpeg,png,docx|max:5120',
            'coa_file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:5120',
        ]);

        // Handle File Uploads first
        $documentTypes = ['grn_file', 'do_file', 'coa_file'];
        foreach ($documentTypes as $type) {
            if ($request->hasFile($type)) {
                $file = $request->file($type);

                // Build a clean, professional filename: e.g., do_file_lot-2026-001_1714561234.pdf
                $filename = $type . '_' . Str::slug($request->lot_number) . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store file in storage/app/public/receipts/ and save the path string
                $path = $file->storeAs('receipts', $filename, 'public');

                // Override the uploaded object in $validated with its file path string
                $validated[$type] = $path;
            } else {
                $validated[$type] = null;
            }
        }

        $validated['received_by'] = auth()->id();
        $validated['type']        = 'supplier';

        // Wrap all DB changes in a transaction to guarantee data integrity
        return DB::transaction(function () use ($validated) {

            $receipt = StockReceipt::create($validated);

            // Increment global item stock
            $receipt->item->increment('quantity', $validated['quantity']);

            // Auto-generate one batch record per unit
            $item       = $receipt->item;
            $itemCode   = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $item->code));
            $receiptPad = str_pad($receipt->id, 6, '0', STR_PAD_LEFT);
            $now        = now();

            $batches = [];
            for ($i = 1; $i <= (int) $validated['quantity']; $i++) {
                $batches[] = [
                    'stock_receipt_id' => $receipt->id,
                    'item_id'          => $item->id,
                    'lot_number'       => $validated['lot_number'],
                    'batch_number'     => $itemCode . '-' . $receiptPad . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'expiry_date'      => $validated['expiry_date'] ?? null,
                    'status'           => 'available',
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ];
            }

            // Bulk insert in chunks of 500 to be memory-friendly
            foreach (array_chunk($batches, 500) as $chunk) {
                DB::table('stock_batches')->insert($chunk);
            }

            AuditLogger::log('created', 'StockReceipt', $receipt->id,
                "Received {$validated['quantity']} {$item->unit} of [{$item->code}] {$item->name} from {$validated['supplier_name']} — Lot: {$validated['lot_number']} — {$validated['quantity']} batches generated"
            );

            return redirect()->route('stock-receipts.show', $receipt)
                ->with('success', "Stock received. {$validated['quantity']} batch numbers generated for Lot {$validated['lot_number']}.");
        });
    }

    // ── Production Return ──────────────────────────────────────────────────────

    public function createReturn()
    {
        $user = auth()->user();

        // Admin/supervisor see all approved requests; operator sees only their own
        $query = ItemRequest::with('item')
            ->where('status', 'approved')
            ->orderBy('updated_at', 'desc');

        if ($user->role === 'operator') {
            $query->where('requested_by', $user->id);
        }

        $approvedRequests = $query->get();

        return view('stock-receipts.create-return', compact('approvedRequests'));
    }

    public function storeReturn(Request $request)
    {
        $validated = $request->validate([
            'item_request_id' => 'required|exists:item_requests,id',
            'quantity'        => 'required|numeric|min:0.01',
            'received_date'   => 'required|date',
            'notes'           => 'nullable|string',
        ]);

        $itemRequest = ItemRequest::with('item')->findOrFail($validated['item_request_id']);

        if ($itemRequest->status !== 'approved') {
            return back()->withErrors(['item_request_id' => 'Only approved requests can be returned.']);
        }

        if ($validated['quantity'] > $itemRequest->quantity_requested) {
            return back()->withErrors(['quantity' => "Cannot return more than the approved quantity ({$itemRequest->quantity_requested} {$itemRequest->item->unit})."]);
        }

        $receipt = StockReceipt::create([
            'type'            => 'production',
            'item_request_id' => $validated['item_request_id'],
            'item_id'         => $itemRequest->item_id,
            'received_by'     => auth()->id(),
            'quantity'        => $validated['quantity'],
            'received_date'   => $validated['received_date'],
            'notes'           => $validated['notes'],
        ]);

        $itemRequest->item->increment('quantity', $validated['quantity']);

        $item = $itemRequest->item;
        AuditLogger::log('created', 'StockReceipt', $receipt->id,
            "Production return: {$validated['quantity']} {$item->unit} of [{$item->code}] {$item->name} (from request #{$itemRequest->id})"
        );

        return redirect()->route('stock-receipts.index', ['type' => 'production'])
            ->with('success', 'Production return recorded. Item quantity updated.');
    }

    public function show(StockReceipt $stockReceipt)
    {
        $stockReceipt->load(['item', 'receiver', 'itemRequest.requester']);
        $batchSummary = null;
        if ($stockReceipt->isFromSupplier()) {
            $available    = StockBatch::where('stock_receipt_id', $stockReceipt->id)->where('status', 'available')->count();
            $issued       = StockBatch::where('stock_receipt_id', $stockReceipt->id)->where('status', 'issued')->count();
            $batchSummary = [
                'total'     => $available + $issued,
                'available' => $available,
                'issued'    => $issued,
            ];
        }
        return view('stock-receipts.show', compact('stockReceipt', 'batchSummary'));
    }

    public function batches(StockReceipt $stockReceipt)
    {
        $stockReceipt->load('item');

        $availableCount = StockBatch::where('stock_receipt_id', $stockReceipt->id)->where('status', 'available')->count();
        $issuedCount    = StockBatch::where('stock_receipt_id', $stockReceipt->id)->where('status', 'issued')->count();
        $totalCount     = $availableCount + $issuedCount;

        $batches = StockBatch::where('stock_receipt_id', $stockReceipt->id)
            ->orderBy('batch_number')
            ->paginate(50);

        return view('stock-receipts.batches', compact('stockReceipt', 'batches', 'totalCount', 'availableCount', 'issuedCount'));
    }
}

