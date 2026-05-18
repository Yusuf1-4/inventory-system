<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'unit', 'quantity', 'created_by', 'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function scopeArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function suppliers()
    {
        return $this->hasMany(ItemSupplier::class);
    }

    public function stockReceipts()
    {
        return $this->hasMany(StockReceipt::class);
    }

    public function itemRequests()
    {
        return $this->hasMany(ItemRequest::class);
    }
}
