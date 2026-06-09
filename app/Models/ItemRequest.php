<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'requested_by', 'quantity_requested', 'purpose', 'notes',
        'vendor_name', 'lot_number', 'batch_number', 'expiry_date',
        'status', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at'  => 'datetime',
        'expiry_date'  => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
