<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'order_date',
        'total_price',
        'payment_method',
        'payment_status',
        'status',
        'user_note',
        'admin_note',
        'ip_address',
    ];

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'order_discount');
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
