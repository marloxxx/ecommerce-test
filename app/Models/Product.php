<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected  $fillable = ['title', 'slug', 'summary', 'description', 'photo', 'stock', 'condition', 'status', 'price', 'discount', 'is_featured', 'brand_id', 'category_id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function getProductBySlug($slug)
    {
        return Product::with('brand', 'category')->where('slug', $slug)->first();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getRatingAttribute()
    {
        $total_rating = 0;
        foreach ($this->reviews as $review) {
            $total_rating = $total_rating + $review->rating;
        }
        if ($this->reviews->count() > 0) {
            return $total_rating / $this->reviews->count();
        } else {
            return 0;
        }
    }

    public function rel_prods()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id')->where('status', 1)->where('id', '!=', $this->id)->limit(8);
    }
}
