<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockBatchController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\StockReceiptController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Item Master – manage static routes MUST come before the {item} wildcard
    Route::middleware('permission:items.manage')->group(function () {
        Route::get('items/bulk-import', [ItemController::class, 'bulkImportForm'])->name('items.bulk-import.form');
        Route::post('items/bulk-import', [ItemController::class, 'bulkImportStore'])->name('items.bulk-import.store');
        Route::delete('items/bulk-delete', [ItemController::class, 'bulkDelete'])->name('items.bulk-delete');
        Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
        Route::get('items/archived', [ItemController::class, 'archivedIndex'])->name('items.archived');
        Route::post('items', [ItemController::class, 'store'])->name('items.store');
        Route::post('items/{item}/archive', [ItemController::class, 'archive'])->name('items.archive');
        Route::post('items/{item}/unarchive', [ItemController::class, 'unarchive'])->name('items.unarchive');
        Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('items/{item}', [ItemController::class, 'update'])->name('items.update');
        Route::patch('items/{item}', [ItemController::class, 'update']);
        Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    });

    // Item Master – view (wildcard {item} must come after static routes above)
    Route::middleware('permission:items.view')->group(function () {
        Route::get('items', [ItemController::class, 'index'])->name('items.index');
        Route::get('items/{item}', [ItemController::class, 'show'])->name('items.show');
    });

    // Stock Receipts – create static route MUST come before the {stockReceipt} wildcard
    Route::middleware('permission:stock-receipts.create')->group(function () {
        Route::get('stock-receipts/create', [StockReceiptController::class, 'create'])->name('stock-receipts.create');
        Route::post('stock-receipts', [StockReceiptController::class, 'store'])->name('stock-receipts.store');
        // Production returns (leftover material sent back from production)
        Route::get('stock-receipts/return', [StockReceiptController::class, 'createReturn'])->name('stock-receipts.return.create');
        Route::post('stock-receipts/return', [StockReceiptController::class, 'storeReturn'])->name('stock-receipts.return.store');
    });

    // Stock Receipts – view (wildcard {stockReceipt} must come after static routes above)
    Route::middleware('permission:stock-receipts.view')->group(function () {
        Route::get('stock-receipts', [StockReceiptController::class, 'index'])->name('stock-receipts.index');
        Route::get('stock-receipts/{stockReceipt}', [StockReceiptController::class, 'show'])->name('stock-receipts.show');
        Route::get('stock-receipts/{stockReceipt}/batches', [StockReceiptController::class, 'batches'])->name('stock-receipts.batches');
    });

    // Item Requests – submit static route MUST come before the {itemRequest} wildcard
    Route::middleware('permission:item-requests.create')->group(function () {
        Route::get('item-requests/create', [ItemRequestController::class, 'create'])->name('item-requests.create');
        Route::post('item-requests', [ItemRequestController::class, 'store'])->name('item-requests.store');
    });

    // Item Requests – view own (wildcard {itemRequest} must come after static routes above)
    Route::middleware('permission:item-requests.view')->group(function () {
        Route::get('item-requests', [ItemRequestController::class, 'index'])->name('item-requests.index');
        Route::get('item-requests/{itemRequest}', [ItemRequestController::class, 'show'])->name('item-requests.show');
    });

    // Item Requests – manage (approve/reject)
    Route::middleware('permission:item-requests.manage')->group(function () {
        Route::post('item-requests/{itemRequest}/approve', [ItemRequestController::class, 'approve'])->name('item-requests.approve');
        Route::post('item-requests/{itemRequest}/reject', [ItemRequestController::class, 'reject'])->name('item-requests.reject');
        Route::get('admin/item-requests', [ItemRequestController::class, 'adminIndex'])->name('item-requests.admin');
    });

    // Stock Batches – browse all batches
    Route::middleware('permission:stock-batches.view')->group(function () {
        Route::get('stock-batches', [StockBatchController::class, 'index'])->name('stock-batches.index');
        Route::get('stock-batches/{stockBatch}/label', [StockBatchController::class, 'label'])->name('stock-batches.label');
        Route::patch('stock-batches/{stockBatch}/tunnel', [StockBatchController::class, 'updateTunnel'])->name('stock-batches.tunnel');
    });

    // Stock Card Report
    Route::middleware('permission:stock-card.view')->group(function () {
        Route::get('stock-card', [StockCardController::class, 'index'])->name('stock-card.index');
    });

    // User Management & Authorization – admin only (hardcoded, not configurable)
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('authorization', [AuthorizationController::class, 'index'])->name('authorization.index');
        Route::put('authorization', [AuthorizationController::class, 'update'])->name('authorization.update');
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('backup', [BackupController::class, 'index'])->name('backup.index');
        Route::get('backup/download/{type}', [BackupController::class, 'download'])->name('backup.download');
    });
});

require __DIR__.'/auth.php';
