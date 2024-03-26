<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_no'
    ];

    public function bill()
    {
        return $this->morphMany(Bill::class, 'billable');
    }

    public function return()
    {
        return $this->morphMany(ReturnedProduct::class, 'returnable');
    }
}
