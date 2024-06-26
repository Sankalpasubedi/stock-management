<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'current_stock',
        'price',
        'unit_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function stock()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function bill()
    {
        return $this->hasMany(Bill::class);
    }

    public function return()
    {
        return $this->hasMany(ReturnedProduct::class);
    }

}
