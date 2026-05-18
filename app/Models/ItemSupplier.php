<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
    protected $fillable = ['item_id', 'supplier_name'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
