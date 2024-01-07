<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(User::class);
    }

    // total cart price
    public static function totalCarts()
    {
        if (auth()->check()) {
            $carts = Cart::where('user_id', auth()->id())
                ->get();
        }

        $total_price = 0;

        foreach ($carts as $cart) {
            $total_price += $cart->product->price * $cart->quantity;
        }

        return $total_price;
    }
}
