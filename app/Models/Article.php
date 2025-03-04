<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'article_category_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_articles', 'article_id', 'product_id');
    }
}
