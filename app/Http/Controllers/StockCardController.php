<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockReceipt;
use App\Models\ItemRequest;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::active()->orderBy('name')->get();

        $selectedItem = null;
        $movements    = collect();
        $balances     = collect();

        if ($request->filled('item_id')) {
            $selectedItem = Item::find($request->item_id);

            if ($selectedItem) {
                // IN movements from stock receipts
                $ins = StockReceipt::with('receiver')
                    ->where('item_id', $selectedItem->id)
                    ->get()
                    ->map(function ($r) {
                        return [
                            'date'        => $r->received_date,
                            'mr_no'       => '—',
                            'batch_no'    => $r->lot_number ?? $r->batch_number ?? '—',
                            'expiry_date' => $r->expiry_date,
                            'in'          => $r->quantity,
                            'out'         => null,
                            'remarks'     => trim(($r->supplier_name ? $r->supplier_name . '. ' : '') . ($r->notes ?? '')),
                            'type'        => $r->type === 'production' ? 'return' : 'in',
                            'sort_key'    => $r->received_date->format('Y-m-d') . '_' . $r->id,
                        ];
                    });

                // OUT movements from approved item requests
                $outs = ItemRequest::with('requester')
                    ->where('item_id', $selectedItem->id)
                    ->where('status', 'approved')
                    ->get()
                    ->map(function ($r) {
                        $date = $r->reviewed_at ? \Carbon\Carbon::parse($r->reviewed_at) : $r->created_at;
                        return [
                            'date'        => $date,
                            'mr_no'       => 'MR-' . str_pad($r->id, 5, '0', STR_PAD_LEFT),
                            'batch_no'    => '—',
                            'expiry_date' => $r->expiry_date,
                            'in'          => null,
                            'out'         => $r->quantity_requested,
                            'remarks'     => trim(($r->purpose ?? '') . ($r->notes ? '. ' . $r->notes : '')),
                            'type'        => 'out',
                            'sort_key'    => $date->format('Y-m-d') . '_' . $r->id,
                        ];
                    });

                $movements = $ins->merge($outs)->sortBy('sort_key')->values();

                // Calculate running balance
                $balance = 0;
                $movements = $movements->map(function ($m) use (&$balance) {
                    if ($m['in']) {
                        $balance += $m['in'];
                    } elseif ($m['out']) {
                        $balance -= $m['out'];
                    }
                    $m['balance'] = $balance;
                    return $m;
                });
            }
        }

        return view('stock-card.index', compact('items', 'selectedItem', 'movements'));
    }
}
