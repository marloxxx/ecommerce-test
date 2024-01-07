<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected  $fillable = [
        'order_number',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'user_id',
        'coupon_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
