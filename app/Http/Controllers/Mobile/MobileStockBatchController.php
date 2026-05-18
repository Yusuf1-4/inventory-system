<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\StockBatch;
use Illuminate\Http\Request;

class MobileStockBatchController extends Controller
{
    /**
     * Look up a batch by QR code content (batch_number).
     */
    public function scan(Request $request)
    {
        $request->validate([
            'batch_number' => 'required|string',
        ]);

        $batch = StockBatch::with('item')
            ->where('batch_number', $request->batch_number)
            ->first();

        if (! $batch) {
            return response()->json(['message' => 'Batch not found'], 404);
        }

        return response()->json($batch);
    }

    /**
     * Update the tunnel assignment for a batch (A, B, C, or null to clear).
     */
    public function updateTunnel(Request $request, StockBatch $stockBatch)
    {
        $request->validate([
            'tunnel' => ['nullable', 'in:A,B,C'],
        ]);

        $stockBatch->update(['tunnel' => $request->tunnel ?: null]);

        return response()->json(['tunnel' => $stockBatch->tunnel]);
    }
}
