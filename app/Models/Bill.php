<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
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
        'discount_amount',
        'discount_percentage',
        'vat',
        'bill_no'
    ];

    public function billable()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function bill()
    {
        return $this->hasMany(Bill::class, 'bill_under');
    }
}
