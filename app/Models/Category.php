<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'summary', 'photo', 'description', 'status', 'is_parent', 'parent_id'];

    public function parent_info()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status', 'active')->orderBy('id', 'DESC');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->where('status', 'active')->orderBy('id', 'DESC');
    }

    public static function getAllParentWithChild()
    {
        return Category::with('subcategories')->where('is_parent', 1)->where('status', 'active')->orderBy('title', 'ASC')->get();
    }

    public function child_cat()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status', 'active');
    }
}
