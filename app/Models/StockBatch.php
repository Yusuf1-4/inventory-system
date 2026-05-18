<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBatch extends Model
{
    protected $fillable = [
        'stock_receipt_id', 'item_id', 'lot_number', 'batch_number',
        'expiry_date', 'status', 'qr_code', 'tunnel',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function stockReceipt()
    {
        return $this->belongsTo(StockReceipt::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isIssued(): bool
    {
        return $this->status === 'issued';
    }
}
