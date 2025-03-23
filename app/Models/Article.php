<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail_url',
        'short_description',
        'content',
        'product_id',
        'user_id',
        'status',
        'article_category_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function articleCategories()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
