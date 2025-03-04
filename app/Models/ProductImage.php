<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'image_url', 'alt_text', 'is_primary', 'status'];

    protected static function booted()
    {
        static::updated(fn() => Cache::forget('products' . $this->product->id));
        static::deleted(fn() => Cache::forget('products' . $this->product->id));
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
