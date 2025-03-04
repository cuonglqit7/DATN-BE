<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_name', 'slug', 'description', 'price', 'status', 'category_id'];

    protected static function booted()
    {
        static::created(fn() => Cache::forget('products'));
        static::updated(fn($product) => [
            Cache::forget('products'),
            Cache::forget("product_{$product->id}"),
        ]);
        static::deleted(fn($product) => [
            Cache::forget('products'),
            Cache::forget("product_{$product->id}"),
        ]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function avatar()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'product_articles', 'product_id', 'article_id');
    }

    public function discounts()
    {
        return $this->hasManyThrough(Discount::class, ProductDiscount::class, 'product_id', 'id', 'id', 'discount_id');
    }
}
