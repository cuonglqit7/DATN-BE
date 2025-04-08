<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = [
        'image_url',
        'alt_text',
        'link',
        'position',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Lấy URL đầy đủ của ảnh
    public function getImageUrlAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
