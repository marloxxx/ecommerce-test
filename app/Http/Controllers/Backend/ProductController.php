<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->with('category.parent_info', 'brand')->get();
        return view('pages.backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('pages.backend.product.create')->with([
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'stock' => "required|numeric",
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
        ]);

        $slug = Str::slug($request->title);
        if (Product::where('slug', $slug)->first() != null) {
            $slug = $slug . '-' . time();
        }

        Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'description' => $request->description,
            'photo' => $request->photo,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'is_featured' => $request->is_featured,
            'status' => $request->status,
            'condition' => $request->condition,
            'price' => $request->price,
        ]);

        return redirect()->route('backend.product.index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('pages.backend.product.edit')->with([
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
        ]);

        $slug = Str::slug($request->title);
        if (Product::where('slug', $slug)->first() != null) {
            $slug = $slug . '-' . time();
        }

        $product->update([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'description' => $request->description,
            'photo' => $request->photo,
            'size' => $request->size,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'is_featured' => $request->is_featured,
            'status' => $request->status,
            'condition' => $request->condition,
            'price' => $request->price,
        ]);

        return redirect()->route('backend.product.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->delete()) {
            return redirect()->route('backend.product.index')->with('success', 'Product deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
