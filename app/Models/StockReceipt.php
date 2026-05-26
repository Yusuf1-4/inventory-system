<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'item_request_id',
        'item_id', 'received_by', 'quantity', 'supplier_name', 'grn_number',
        'lot_number', 'batch_number', 'expiry_date', 'received_date', 'notes',
        'grn_file', 'do_file', 'coa_file', // Added for supporting document uploads
    ];

    protected $casts = [
        'received_date' => 'date',
        'expiry_date'   => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function itemRequest()
    {
        return $this->belongsTo(\App\Models\ItemRequest::class);
    }

    public function batches()
    {
        return $this->hasMany(StockBatch::class);
    }

    public function isFromSupplier(): bool
    {
        return $this->type === 'supplier';
    }

    public function isFromProduction(): bool
    {
        return $this->type === 'production';
    }
}
