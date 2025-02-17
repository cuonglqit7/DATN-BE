<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentCategory extends Model
{
    use HasFactory;

    protected $table = 'parent_categories';

    protected $fillable = ['name', 'slug', 'position', 'status'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'parent_category_id');
    }
}
