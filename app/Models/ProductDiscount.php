<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDiscount extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'discount_id'];

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
