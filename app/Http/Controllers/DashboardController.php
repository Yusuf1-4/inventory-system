<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemRequest;
use App\Models\StockReceipt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalStock = Item::sum('quantity');
        $pendingRequests = ItemRequest::where('status', 'pending')->count();
        $lowStockItems = Item::where('quantity', '<=', 10)->count();
        $recentRequests = ItemRequest::with(['item', 'requester'])
            ->latest()
            ->take(5)
            ->get();
        $recentReceipts = StockReceipt::with(['item', 'receiver'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalItems', 'totalStock', 'pendingRequests',
            'lowStockItems', 'recentRequests', 'recentReceipts'
        ));
    }
}
