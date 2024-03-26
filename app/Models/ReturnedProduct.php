<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'payable',
        'receivable',
        'total_bill_amount',
        'total_product_amount',
        'product_id',
        'bill_under',
        'bill_end_date',
        'stock',
        'rate',
        'bill_no'
    ];

    public function returnable()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function return()
    {
        return $this->hasMany(ReturnedProduct::class, 'bill_under');
    }
}

