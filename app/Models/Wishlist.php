<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function wishlist()
    {
        return $this->belongsTo(User::class);
    }

    // total price
    public static function totalWishlist()
    {
        if (auth()->check()) {
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->get();
        } else {
            $wishlist = Wishlist::where('ip_address', request()->ip())->get();
        }

        $total_price = 0;

        foreach ($wishlist as $item) {
            if (!is_null($item->product->offer_price)) {
                $total_price += $item->product->offer_price * $item->quantity;
            } else {
                $total_price += $item->product->price * $item->quantity;
            }
        }

        return $total_price;
    }
}
