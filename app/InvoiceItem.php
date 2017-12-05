<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'product_id', 'unit_price', 'qty'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
