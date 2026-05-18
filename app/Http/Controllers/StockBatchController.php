<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockBatch;
use Illuminate\Http\Request;

class StockBatchController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::active()->orderBy('name')->get();

        $query = StockBatch::with(['item', 'stockReceipt'])
            ->orderBy('batch_number');

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->filled('lot_number')) {
            $query->where('lot_number', 'like', '%' . $request->lot_number . '%');
        }

        if ($request->filled('batch_number')) {
            $query->where('batch_number', 'like', '%' . $request->batch_number . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Count before paginating
        $totalCount     = (clone $query)->count();
        $availableCount = (clone $query)->where('status', 'available')->count();
        $issuedCount    = (clone $query)->where('status', 'issued')->count();

        $batches = $query->paginate(50)->withQueryString();

        return view('stock-batches.index', compact(
            'batches', 'items', 'totalCount', 'availableCount', 'issuedCount'
        ));
    }

    public function label(StockBatch $stockBatch)
    {
        $stockBatch->load(['item', 'stockReceipt']);
        return view('stock-batches.label', compact('stockBatch'));
    }

    public function updateTunnel(Request $request, StockBatch $stockBatch)
    {
        $valid = array_merge(
            array_map(fn($n) => "P{$n}", range(1, 8)),
            array_map(fn($n) => "N{$n}", range(1, 9)),
            array_map(fn($n) => "M{$n}", range(1, 15)),
            ['R2', 'R1'],
            array_map(fn($n) => "L{$n}", range(1, 9)),
            ['S2', 'S1'],
            array_map(fn($n) => "K{$n}", range(1, 9)),
            array_map(fn($n) => "T{$n}", range(1, 6))
        );

        $request->validate([
            'tunnel' => ['nullable', 'in:' . implode(',', $valid)],
        ]);

        $stockBatch->update(['tunnel' => $request->tunnel]);

        return response()->json(['tunnel' => $stockBatch->tunnel]);
    }
}
