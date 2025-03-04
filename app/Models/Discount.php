<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    protected $fillable = [
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'created_at',
    ];
}
