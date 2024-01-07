<?php

namespace App\Http\Controllers\Backend;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        return view('pages.backend.brand.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|required',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->title);
        if (Brand::where('slug', $slug)->first() != null) {
            $slug = $slug . '-' . time();
        }

        Brand::create([
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('backendbrand.index')->with('success', 'Brand created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('pages.backend.brand.edit')->with('brand', $brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'title' => 'string|required',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->title);
        if (Brand::where('slug', $slug)->first() != null) {
            $slug = $slug . '-' . time();
        }

        $brand->update([
            'title' => $request->title,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return redirect()->route('backendbrand.index')->with('success', 'Brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->delete()) {
            return redirect()->route('backendbrand.index')->with('success', 'Brand deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
