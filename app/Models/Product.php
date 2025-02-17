<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price', 'status', 'sub_category_id'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function parentCategory()
    {
        return $this->hasOneThrough(ParentCategory::class, SubCategory::class, 'id', 'id', 'sub_category_id', 'parent_category_id');
    }
}
