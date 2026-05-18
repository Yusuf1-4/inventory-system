<?php

use App\Http\Controllers\Mobile\MobileAuthController;
use App\Http\Controllers\Mobile\MobileStockBatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ── Mobile App API ──────────────────────────────────────────────────────────

// Public: login
Route::post('/mobile/login', [MobileAuthController::class, 'login']);

// Protected: require Sanctum token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/mobile/logout', [MobileAuthController::class, 'logout']);

    // Scan batch by batch_number from QR code
    Route::get('/mobile/stock-batches/scan', [MobileStockBatchController::class, 'scan']);

    // Update tunnel for a batch
    Route::patch('/mobile/stock-batches/{stockBatch}/tunnel', [MobileStockBatchController::class, 'updateTunnel']);
});
