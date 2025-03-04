<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'slug', 'description', 'position', 'status'];

    protected static function booted()
    {
        static::updated(fn() => Cache::forget('products'));
        static::deleted(fn() => Cache::forget('products'));
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
