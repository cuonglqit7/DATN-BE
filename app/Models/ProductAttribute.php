<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'attribute_name', 'attribute_value', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
