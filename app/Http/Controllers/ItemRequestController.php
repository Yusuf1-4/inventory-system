<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class ItemRequestController extends Controller
{
    public function index()
    {
        $requests = ItemRequest::with(['item', 'requester'])
            ->where('requested_by', auth()->id())
            ->latest()
            ->paginate(15);
        return view('item-requests.index', compact('requests'));
    }

    public function create()
    {
        $items = Item::with(['suppliers', 'stockReceipts'])->where('quantity', '>', 0)->active()->orderBy('name')->get();

        // Build map: item_id => { vendor_name => [expiry_dates] }
        $itemVendorData = $items->mapWithKeys(function ($item) {
            $vendors = $item->stockReceipts
                ->groupBy('supplier_name')
                ->map(function ($recs) {
                    return $recs->pluck('expiry_date')
                        ->filter()
                        ->map(fn($d) => $d->format('Y-m-d'))
                        ->unique()->sort()->values();
                });
            return [$item->id => $vendors];
        });

        return view('item-requests.create', compact('items', 'itemVendorData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'            => 'required|exists:items,id',
            'quantity_requested' => 'required|numeric|min:0.01',
            'purpose'            => 'required|string|max:255',
            'notes'              => 'nullable|string',
            'vendor_name'        => 'nullable|string|max:255',
            'expiry_date'        => 'nullable|date',
        ]);

        $item = Item::findOrFail($validated['item_id']);
        if ($item->quantity < $validated['quantity_requested']) {
            return back()->withErrors(['quantity_requested' => 'Requested quantity exceeds available stock (' . $item->quantity . ' ' . $item->unit . ')']);
        }

        $validated['requested_by'] = auth()->id();
        $validated['status']       = 'pending';

        $itemRequest = ItemRequest::create($validated);

        AuditLogger::log('created', 'ItemRequest', $itemRequest->id,
            "Submitted request for {$validated['quantity_requested']} {$item->unit} of [{$item->code}] {$item->name}: {$validated['purpose']}"
        );

        return redirect()->route('item-requests.index')
            ->with('success', 'Request submitted successfully. Waiting for approval.');
    }

    public function show(ItemRequest $itemRequest)
    {
        $itemRequest->load(['item', 'requester', 'reviewer']);
        return view('item-requests.show', compact('itemRequest'));
    }

    // Admin: view all requests
    public function adminIndex()
    {
        $requests = ItemRequest::with(['item', 'requester'])->latest()->paginate(15);
        return view('item-requests.admin-index', compact('requests'));
    }

    // Admin: approve request
    public function approve(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $item = $itemRequest->item;
        if ($item->quantity < $itemRequest->quantity_requested) {
            return back()->with('error', 'Insufficient stock to approve this request.');
        }

        $itemRequest->update([
            'status'      => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Deduct stock
        $item->decrement('quantity', $itemRequest->quantity_requested);

        AuditLogger::log('approved', 'ItemRequest', $itemRequest->id,
            "Approved request for {$itemRequest->quantity_requested} {$item->unit} of [{$item->code}] {$item->name}"
        );

        return back()->with('success', 'Request approved. Stock deducted.');
    }

    // Admin: reject request
    public function reject(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $itemRequest->update([
            'status'      => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $rejItem = $itemRequest->item;
        AuditLogger::log('rejected', 'ItemRequest', $itemRequest->id,
            "Rejected request for {$itemRequest->quantity_requested} {$rejItem->unit} of [{$rejItem->code}] {$rejItem->name}"
        );

        return back()->with('success', 'Request rejected.');
    }
}
